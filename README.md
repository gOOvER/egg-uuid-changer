[![Pelican Panel](https://img.shields.io/badge/Pelican_Panel-Plugin-0e7490?style=flat-square&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IndoaXRlIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCI+PHBhdGggZD0iTTEyIDJhMTAgMTAgMCAxIDAgMTAgMTBBMTAgMTAgMCAwIDAgMTIgMnoiLz48L3N2Zz4=)](https://pelican.dev)
[![GitHub Release](https://img.shields.io/github/v/release/gOOvER/egg-uuid-changer?style=flat-square&logo=github)](https://github.com/gOOvER/egg-uuid-changer/releases)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=flat-square&logo=php)](https://www.php.net/)
[![License](https://img.shields.io/github/license/gOOvER/egg-uuid-changer?style=flat-square)](LICENSE.md)
[![Discord](https://img.shields.io/discord/1158000498952126464?style=flat-square&logo=discord&logoColor=white&label=Discord&color=5865F2)](https://discord.com/invite/RmqSeYBQ4y)
[![Donate](https://img.shields.io/badge/Donate-❤_Support-ff69b4?style=flat-square)](https://donate.goover.dev)

# Egg UUID Changer

Changes the UUID of existing Eggs in Pelican Panel. That's it.

## Why would you need this?

Sometimes you need to match UUIDs between different panel installations, or you imported an Egg and want to restore or customize its UUID. This plugin lets you do that directly in the Admin Panel without touching the database manually.

The plugin hooks into Filament's header action system on the `EditEgg` page. All UUID changes are protected by authorization checks and wrapped in atomic database transactions.

## Installation

### Via Panel (recommended)

1. Download `egg-uuid-changer.zip` from the latest [GitHub Release](https://github.com/gOOvER/egg-uuid-changer/releases)
2. Go to **Admin Area → Plugins**
3. Click **Import** and select `egg-uuid-changer.zip`
4. Enable the plugin

### Manual

```bash
cd /var/www/pelican/plugins
git clone https://github.com/gOOvER/egg-uuid-changer.git egg-uuid-changer
cd /var/www/pelican
php artisan p:plugin:install egg-uuid-changer
php artisan optimize:clear
```

## Usage

Open any Egg in the Admin Panel (`Admin Area → Eggs → Edit`). You'll see a **Change UUID** button in the page header. Click it to:
- View and copy the current UUID as a backup
- Enter a custom UUID or leave the field blank to generate a new UUID v4 automatically
- Confirm to update the Egg's UUID immediately

## Warnings

Changing an Egg's UUID after it is already in use can affect existing resources:

- Wings might need a server sync if the Egg UUID is referenced
- External integrations or billing modules referencing the old UUID will need to be updated
- Update checks cached under the old UUID are automatically cleared

Only change UUIDs if you know what you're doing. Copy the old UUID as a backup first.

## Requirements

- Pelican Panel `^1.0.0` (including `1.0.0-rc.2` / Filament v4)
- PHP `8.3+`

## License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE.md](LICENSE.md) file for details.
