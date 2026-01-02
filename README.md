[![GitHub Release](https://img.shields.io/github/v/release/gOOvER/egg-uuid-changer?style=flat-square&logo=github)](https://github.com/gOOvER/egg-uuid-changer/releases)
[![GitHub Downloads](https://img.shields.io/github/downloads/gOOvER/egg-uuid-changer/total?style=flat-square&logo=github)](https://github.com/gOOvER/egg-uuid-changer/releases)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![License](https://img.shields.io/github/license/gOOvER/egg-uuid-changer?style=flat-square)](LICENSE.md)
[![Discord](https://img.shields.io/discord/1158000498952126464?style=flat-square&logo=discord&logoColor=white&label=Discord&color=5865F2)](https://discord.com/invite/RmqSeYBQ4y)

[![Syntax Check](https://img.shields.io/github/actions/workflow/status/gOOvER/egg-uuid-changer/syntax-check.yml?branch=master&style=flat-square&label=Syntax%20Check&logo=github-actions)](https://github.com/gOOvER/egg-uuid-changer/actions/workflows/syntax-check.yml)
[![Plugin Validation](https://img.shields.io/github/actions/workflow/status/gOOvER/egg-uuid-changer/plugin-validation.yml?branch=master&style=flat-square&label=Validation&logo=github-actions)](https://github.com/gOOvER/egg-uuid-changer/actions/workflows/plugin-validation.yml)
[![Code Quality](https://img.shields.io/github/actions/workflow/status/gOOvER/egg-uuid-changer/code-quality.yml?branch=master&style=flat-square&label=Code%20Quality&logo=github-actions)](https://github.com/gOOvER/egg-uuid-changer/actions/workflows/code-quality.yml)

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
git clone https://github.com/gOOvER/egg-uuid-changer.git egg-uuid-changer
cd /var/www/pelican
php artisan plugin:enable egg-uuid-changer
php artisan optimize:clear
```

## Usage

Open any egg in the admin panel. You'll see a "Change UUID" button at the top. Click it to:
- View the current UUID (you can copy it for backup)
- Enter a new UUID or leave blank to generate one automatically
- Confirm and the UUID will be updated immediately

The page will automatically reload after the UUID change to show the updated value.

## Configuration

You can add these to your `.env` if needed:

```env
EGG_UUID_CHANGER_ENABLED=true
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

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.md](LICENSE.md) file for details.
