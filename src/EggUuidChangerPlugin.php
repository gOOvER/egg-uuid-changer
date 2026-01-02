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
use Filament\Forms\Components\Checkbox;
use Livewire\Component;

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

        // Hook into the save action if auto-prompt is enabled
        if (config('egg-uuid-changer.auto_prompt_on_save', false)) {
            static::registerSaveHook();
        }

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
                static::changeUuid($record, $data['new_uuid'] ?? null);
            });
    }

    /**
     * Register hook to prompt UUID change on save
     */
    protected static function registerSaveHook(): void
    {
        EditEgg::registerCustomFormActions(
            static::getPromptUuidChangeOnSave()
        );
    }

    /**
     * Create the action to prompt UUID change when saving
     */
    protected static function getPromptUuidChangeOnSave(): Action
    {
        return Action::make('save_with_uuid_prompt')
            ->label(trans('egg-uuid-changer::messages.save_button_label'))
            ->icon('tabler-device-floppy')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading(trans('egg-uuid-changer::messages.save_modal_heading'))
            ->modalDescription(trans('egg-uuid-changer::messages.save_modal_description'))
            ->form([
                Checkbox::make('change_uuid')
                    ->label(trans('egg-uuid-changer::messages.save_form.change_uuid_label'))
                    ->helperText(trans('egg-uuid-changer::messages.save_form.change_uuid_helper'))
                    ->default(false),
                TextInput::make('new_uuid')
                    ->label(trans('egg-uuid-changer::messages.form.new_uuid_label'))
                    ->placeholder(trans('egg-uuid-changer::messages.form.new_uuid_placeholder'))
                    ->helperText(trans('egg-uuid-changer::messages.form.new_uuid_helper'))
                    ->maxLength(36)
                    ->visible(fn (\Filament\Forms\Get $get) => $get('change_uuid'))
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if (empty($value)) {
                                    return;
                                }

                                if (!Uuid::isValid($value)) {
                                    $fail(trans('egg-uuid-changer::messages.validation.invalid_uuid'));
                                }

                                if (Egg::where('uuid', $value)->exists()) {
                                    $fail(trans('egg-uuid-changer::messages.validation.duplicate_uuid'));
                                }
                            };
                        },
                    ]),
            ])
            ->action(function (array $data, Egg $record, Component $livewire) {
                // Save the egg first
                $livewire->form->getState();
                $record->save();

                // Then change UUID if requested
                if ($data['change_uuid'] ?? false) {
                    static::changeUuid($record, $data['new_uuid'] ?? null);
                } else {
                    Notification::make()
                        ->title(trans('egg-uuid-changer::messages.notifications.save_success_title'))
                        ->success()
                        ->send();
                }
            });
    }

    /**
     * Change the UUID of an egg
     */
    protected static function changeUuid(Egg $record, ?string $newUuid = null): void
    {
        $oldUuid = $record->uuid;
        $newUuid = !empty($newUuid) ? $newUuid : Str::uuid()->toString();

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
