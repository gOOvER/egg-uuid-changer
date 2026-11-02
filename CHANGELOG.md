# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.1] - 2026-11-02

### Fixed
- Fixed `Class "\goover\EggUuidChanger\EggUuidChangerPlugin" not found` and `Target class [cache] does not exist` on Pelican Panel pre-release versions (`1.0.0-rc.2` / `1.0.0-beta*`) by setting `"panel_version": null` and adding `"api_version": 1` in `plugin.json` (PHP's `version_compare` treats `1.0.0-rc.2` as lower than `^1.0.0`, which caused `PluginService::loadPlugins()` to skip PSR-4 autoloader registration)
- Moved `EditEgg::registerCustomHeaderActions()` registration from `register()` to `boot()` so all Laravel service providers and Filament panel configurations are fully booted first

## [1.1.0] - 2026-11-02

### Added
- Added Pelican Hub `update_url`, `url`, `panels` (`["admin"]`), and `panel_version` metadata to `plugin.json`
- Added tooltip to the header action button for compatibility with Pelican Panel's icon-only button style (`CustomizationKey::ButtonStyle`)
- Added validation rule preventing redundant updates when entering the same UUID as the current Egg
- Added automatic cache invalidation for `eggs.{old_uuid}.update` after changing an Egg's UUID

### Changed
- Migrated Filament action modal form definition from deprecated `->form()` to Filament v4 `->schema()` and `TablerIcon` enum icons
- Switched `current_uuid` field from `disabled()` to `readOnly()` so text selection and the copy action work reliably across all browsers
- Updated action labels, tooltips, descriptions, placeholders, and helper texts to use lazy closures (`fn () => trans(...)`) so translations always resolve in the active user's locale
- Replaced full-page route redirect after UUID change with in-place Livewire form state synchronization (`$livewire->data['uuid']`) to preserve unsaved form edits
- Cleaned up unused legacy import/save translation keys and fixed formatting in `lang/en/messages.php` and `lang/de/messages.php`
- Updated `.github/FUNDING.yml`, `.github/workflows/release.yml` (packaging `egg-uuid-changer.zip` for Panel Import compatibility), and `README.md` (`php artisan p:plugin:install`)

### Fixed
- Scoped plugin registration strictly to the `admin` panel (`$panel->getId() === 'admin'`) to prevent premature static registration on non-admin panels
- Normalized and trimmed custom UUID inputs (`strtolower(trim(...))`), rejected nil UUIDs (`00000000-0000-0000-0000-000000000000`), and excluded the current Egg ID on uniqueness checks
- Fixed race condition during UUID changes by verifying uniqueness with `lockForUpdate()` inside `DB::transaction()`

### Security
- Added missing `->authorize('update')` policy check on the Filament header action and backend `user()?->can('update', $record)` verification in `changeUuid()` to prevent unauthorized users with read-only Egg access from modifying UUIDs
- Prevented raw database/SQL exception details (`$e->getMessage()`) from leaking into user-facing error notifications; exceptions are now logged via `report($exception)` with a safe localized error message

## [1.0.0] - 2026-01-02

### Added
- Initial release
- UUID change functionality via button on egg edit page
- Display current UUID in dialog for easy copying
- Automatic UUID generation option
- Duplicate UUID validation
- Transaction-safe database operations
- English and German translations

### Notes
- Import-time UUID prompt was attempted but removed due to technical limitations with Pelican Panel's import system
