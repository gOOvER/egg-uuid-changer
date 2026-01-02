<?php

namespace EggUuidChanger;

use App\Enums\HeaderActionPosition;
use App\Filament\Admin\Resources\Eggs\Pages\EditEgg;
use App\Models\Egg;
use Filament\Actions\Action;
use Filament\Contracts\Plugin;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Panel;
use Filament\Support\Enums\IconSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class EggUuidChangerPlugin implements Plugin
{
    protected static bool $registered = false;

    public function getId(): string
    {
        return 'egg-uuid-changer';
    }

    public function register(Panel $panel): void
    {
        // Prevent multiple registrations
        if (static::$registered) {
            return;
        }

        // Add custom action to Edit Egg page
        EditEgg::registerCustomHeaderActions(
            HeaderActionPosition::Before,
            static::getChangeUuidActionStatic()
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
     * Create the action to change egg UUID
     */
    protected static function getChangeUuidActionStatic(): Action
    {
        return Action::make('change_uuid')
            ->label(trans('egg-uuid-changer::messages.button_label'))
            ->icon('tabler-refresh')
            ->iconSize(IconSize::Large)
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading(trans('egg-uuid-changer::messages.modal_heading'))
            ->modalDescription(trans('egg-uuid-changer::messages.modal_description'))
            ->modalIcon('tabler-alert-triangle')
            ->modalIconColor('warning')
            ->form([
                TextInput::make('new_uuid')
                    ->label(trans('egg-uuid-changer::messages.form.new_uuid_label'))
                    ->placeholder(trans('egg-uuid-changer::messages.form.new_uuid_placeholder'))
                    ->helperText(trans('egg-uuid-changer::messages.form.new_uuid_helper'))
                    ->maxLength(36)
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if (empty($value)) {
                                    return;
                                }

                                // Check if valid UUID format
                                if (!Uuid::isValid($value)) {
                                    $fail(trans('egg-uuid-changer::messages.validation.invalid_uuid'));
                                }

                                // Check if UUID already exists
                                if (Egg::where('uuid', $value)->exists()) {
                                    $fail(trans('egg-uuid-changer::messages.validation.duplicate_uuid'));
                                }
                            };
                        },
                    ]),
            ])
            ->action(function (array $data, Egg $record) {
                $oldUuid = $record->uuid;
                $newUuid = !empty($data['new_uuid']) ? $data['new_uuid'] : Str::uuid()->toString();

                try {
                    DB::beginTransaction();

                    // Update the egg's UUID
                    $record->uuid = $newUuid;
                    $record->save();

                    DB::commit();

                    Notification::make()
                        ->title(trans('egg-uuid-changer::messages.notifications.success_title'))
                        ->body(trans('egg-uuid-changer::messages.notifications.success_body', ['old' => $oldUuid, 'new' => $newUuid]))
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    DB::rollBack();

                    Notification::make()
                        ->title(trans('egg-uuid-changer::messages.notifications.error_title'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
