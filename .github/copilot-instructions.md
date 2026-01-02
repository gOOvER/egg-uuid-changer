# Pelican Panel Plugin: Egg UUID Changer

## Project Type
PHP Plugin für Pelican Panel

## Technology Stack
- PHP 8.1+
- Laravel 10.x
- Filament PHP (Admin Panel Framework)
- Pelican Panel Plugin System

## Project Structure
```
egg-uuid-changer/
├── plugin.json                    # Plugin-Metadaten
├── config/
│   └── egg-uuid-changer.php      # Konfiguration
├── src/
│   ├── EggUuidChangerPlugin.php  # Haupt-Plugin-Klasse
│   └── Providers/
│       └── EggUuidChangerServiceProvider.php
└── README.md                      # Dokumentation
```

## Development Guidelines
- Plugin folgt der Pelican Panel Plugin-Struktur
- Nutzt Filament Actions für UI-Integration
- Service Provider für Laravel-Integration
- Transaktionssichere Datenbankoperationen
