<?php

namespace goover\EggUuidChanger;

use App\Enums\HeaderActionPosition;
use App\Enums\TablerIcon;
use App\Filament\Admin\Resources\Eggs\Pages\EditEgg;
use App\Models\Egg;
use Closure;
use Filament\Actions\Action;
use Filament\Contracts\Plugin;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\Support\Enums\IconSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Livewire\Component;
use Ramsey\Uuid\Uuid;
use RuntimeException;
use Throwable;

class EggUuidChangerPlugin implements Plugin
{
    protected static bool $registered = false;

    public function getId(): string
    {
        return 'egg-uuid-changer';
    }

    public function register(Panel $panel): void
    {
        if ($panel->getId() !== 'admin' || static::$registered) {
            return;
        }

        EditEgg::registerCustomHeaderActions(
            HeaderActionPosition::Before,
            static::getChangeUuidActionStatic(),
        );

        static::$registered = true;
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    /**
     * Create the action to change egg UUID.
     */
    protected static function getChangeUuidActionStatic(): Action
    {
        return Action::make('change_uuid')
            ->label(fn (): string => trans('egg-uuid-changer::messages.button_label'))
            ->tooltip(fn (): string => trans('egg-uuid-changer::messages.button_label'))
            ->icon(TablerIcon::Refresh)
            ->iconSize(IconSize::Large)
            ->color('warning')
            ->authorize('update')
            ->requiresConfirmation()
            ->modalHeading(fn (): string => trans('egg-uuid-changer::messages.modal_heading'))
            ->modalDescription(fn (): string => trans('egg-uuid-changer::messages.modal_description'))
            ->modalIcon(TablerIcon::AlertTriangle)
            ->modalIconColor('warning')
            ->fillForm(fn (Egg $record): array => [
                'current_uuid' => $record->uuid,
            ])
            ->schema([
                TextInput::make('current_uuid')
                    ->label(fn (): string => trans('egg-uuid-changer::messages.form.current_uuid_label'))
                    ->readOnly()
                    ->dehydrated(false)
                    ->copyable()
                    ->helperText(fn (): string => trans('egg-uuid-changer::messages.form.current_uuid_helper')),
                TextInput::make('new_uuid')
                    ->label(fn (): string => trans('egg-uuid-changer::messages.form.new_uuid_label'))
                    ->placeholder(fn (): string => trans('egg-uuid-changer::messages.form.new_uuid_placeholder'))
                    ->helperText(fn (): string => trans('egg-uuid-changer::messages.form.new_uuid_helper'))
                    ->trim()
                    ->maxLength(36)
                    ->rules([
                        fn (Egg $record): Closure => function (string $attribute, mixed $value, Closure $fail) use ($record): void {
                            if (!is_string($value) || trim($value) === '') {
                                return;
                            }

                            $normalized = strtolower(trim($value));

                            if (!Uuid::isValid($normalized) || $normalized === Uuid::NIL) {
                                $fail(trans('egg-uuid-changer::messages.validation.invalid_uuid'));

                                return;
                            }

                            if ($normalized === strtolower($record->uuid)) {
                                $fail(trans('egg-uuid-changer::messages.validation.same_uuid'));

                                return;
                            }

                            if (Egg::query()->where('uuid', $normalized)->where('id', '!=', $record->id)->exists()) {
                                $fail(trans('egg-uuid-changer::messages.validation.duplicate_uuid'));
                            }
                        },
                    ]),
            ])
            ->action(function (array $data, Egg $record, Component $livewire): void {
                if (static::changeUuid($record, $data['new_uuid'] ?? null)) {
                    $record->refresh();

                    if (isset($livewire->data) && is_array($livewire->data)) {
                        $livewire->data['uuid'] = $record->uuid;
                    } elseif (method_exists($livewire, 'refreshForm')) {
                        $livewire->refreshForm();
                    }
                }
            });
    }

    /**
     * Change the UUID of an egg.
     */
    protected static function changeUuid(Egg $record, ?string $newUuid = null): bool
    {
        if (!user()?->can('update', $record)) {
            Notification::make()
                ->title(trans('egg-uuid-changer::messages.notifications.error_title'))
                ->body(trans('egg-uuid-changer::messages.notifications.unauthorized_body'))
                ->danger()
                ->send();

            return false;
        }

        $oldUuid = $record->uuid;
        $normalizedUuid = is_string($newUuid) && trim($newUuid) !== ''
            ? strtolower(trim($newUuid))
            : null;

        try {
            $finalUuid = DB::transaction(function () use ($record, $normalizedUuid): string {
                if ($normalizedUuid !== null) {
                    if (!Uuid::isValid($normalizedUuid) || $normalizedUuid === Uuid::NIL) {
                        throw new InvalidArgumentException('invalid_uuid');
                    }

                    if (Egg::query()->where('uuid', $normalizedUuid)->where('id', '!=', $record->id)->lockForUpdate()->exists()) {
                        throw new RuntimeException('duplicate_uuid');
                    }

                    $targetUuid = $normalizedUuid;
                } else {
                    do {
                        $targetUuid = strtolower(Str::uuid()->toString());
                    } while (Egg::query()->where('uuid', $targetUuid)->exists());
                }

                $record->uuid = $targetUuid;
                $record->save();

                return $targetUuid;
            });

            cache()->forget("eggs.{$oldUuid}.update");

            Notification::make()
                ->title(trans('egg-uuid-changer::messages.notifications.success_title'))
                ->body(trans('egg-uuid-changer::messages.notifications.success_body', [
                    'old' => $oldUuid,
                    'new' => $finalUuid,
                ]))
                ->success()
                ->send();

            return true;
        } catch (InvalidArgumentException) {
            Notification::make()
                ->title(trans('egg-uuid-changer::messages.notifications.error_title'))
                ->body(trans('egg-uuid-changer::messages.validation.invalid_uuid'))
                ->danger()
                ->send();

            return false;
        } catch (RuntimeException) {
            Notification::make()
                ->title(trans('egg-uuid-changer::messages.notifications.error_title'))
                ->body(trans('egg-uuid-changer::messages.validation.duplicate_uuid'))
                ->danger()
                ->send();

            return false;
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()
                ->title(trans('egg-uuid-changer::messages.notifications.error_title'))
                ->body(trans('egg-uuid-changer::messages.notifications.error_body'))
                ->danger()
                ->send();

            return false;
        }
    }
}
