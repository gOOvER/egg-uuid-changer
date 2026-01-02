# Egg UUID Changer

Changes the UUID of existing eggs in Pelican Panel. That's it.

## Why would you need this?

Sometimes you need to match UUIDs between different panel installations, or you imported an egg and want to keep the original UUID. This plugin lets you do that without messing around in the database.

The plugin hooks into Filament's action system to add a button on the EditEgg page. All UUID changes are wrapped in database transactions for safety.

## Installation

### Via Panel (recommended)

1. Download or create a ZIP of this plugin
2. Go to Admin Area → Plugins
3. Click Import and select the ZIP file
4. Done

### Manual

```bash
cd /var/www/pelican/plugins
git clone <repo> egg-uuid-changer
cd /var/www/pelican
php artisan plugin:enable egg-uuid-changer
php artisan optimize:clear
```

## Usage

Open any egg in the admin panel. You'll see a "Change UUID" button at the top. Click it, enter a new UUID (or leave blank to generate one), confirm, and save.

### Auto-Prompt on Save (Optional)

You can enable an optional feature that prompts you to change the UUID every time you save an egg. To enable this, add to your `.env`:

```env
EGG_UUID_CHANGER_AUTO_PROMPT_ON_SAVE=true
```

When enabled, clicking the save button will show a dialog asking if you want to change the UUID. You can:
- Check the box to enable UUID change
- Leave the new UUID field empty to auto-generate
- Or enter a specific UUID
- Uncheck the box to save without changing the UUID

### Auto-Prompt on Import (Optional)

You can also enable a feature that allows you to change the UUID when importing an egg. To enable this, add to your `.env`:

```env
EGG_UUID_CHANGER_AUTO_PROMPT_ON_IMPORT=true
```

When enabled, you'll see an "Import with UUID change" button on the create egg page. Click it before importing to:
- Enable automatic UUID change after import
- Leave the UUID field empty for auto-generation
- Or specify a custom UUID
- Then proceed with your normal egg import

The page won't reload automatically after changing the UUID. Just refresh manually or switch pages to see the updated value.

## Configuration

You can add these to your `.env` if needed:

```env
EGG_UUID_CHANGER_ENABLED=true
EGG_UUID_CHANGER_AUTO_PROMPT_ON_SAVE=false
EGG_UUID_CHANGER_AUTO_PROMPT_ON_IMPORT=false
EGG_UUID_CHANGER_ALLOW_DUPLICATE=false
EGG_UUID_CHANGER_REQUIRE_CONFIRMATION=true
```

Default values work fine for most cases.

## Warnings

Changing an egg's UUID after it's already in use can break things. Specifically:

- Wings might not recognize the egg anymore
- Existing servers using this egg could have issues
- Any external integrations referencing the UUID will break

Only change UUIDs if you know what you're doing. Make a backup first.

## Requirements

- Pelican Panel 1.0.0-beta30+
- PHP 8.3+

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.
