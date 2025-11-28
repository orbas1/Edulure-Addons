# RocketLMS Communities & Chatroom Addon

A production-ready Laravel package that brings communities, channels, real-time chat, DMs, leaderboards, heatmaps, gamification, pricing tiers, and moderation to RocketLMS without touching core files.

## Requirements
- PHP 8.1+
- Laravel 10+
- RocketLMS (current release) with existing auth stack
- Database supported by Laravel migrations

## Installation
1. Require the package in your RocketLMS project:
   ```bash
   composer require rocketaddons/communities
   ```
2. If Laravel auto-discovery is disabled, register the provider in `config/app.php`:
   ```php
   'providers' => [
       // ...
       RocketAddons\Communities\Providers\CommunitiesServiceProvider::class,
   ];
   ```
3. Publish config, migrations, translations, views, and assets:
   ```bash
   php artisan vendor:publish --provider="RocketAddons\\Communities\\Providers\\CommunitiesServiceProvider" --tag=config
   php artisan vendor:publish --provider="RocketAddons\\Communities\\Providers\\CommunitiesServiceProvider" --tag=migrations
   php artisan vendor:publish --provider="RocketAddons\\Communities\\Providers\\CommunitiesServiceProvider" --tag=lang
   php artisan vendor:publish --provider="RocketAddons\\Communities\\Providers\\CommunitiesServiceProvider" --tag=views
   ```
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Seed optional defaults (roles/bad words) as needed.

## Configuration
Key flags live in `config/communities.php`:
- `enabled`: master switch
- `features`: toggle leaderboard, central feed, channels, dm, heatmap, pricing_tiers, chatroom, file_scanning, bad_word_filter
- `chat` and `file_scanner` sections: configure broadcast prefixes, file limits, and scanner drivers
- `moderation` and `gamification`: thresholds, actions, and point tables

Posting endpoints are guarded by `communities.can_post`, which blocks muted, pending, or banned members from submitting feed items or channel reactions/messages.

When a feature is disabled, routes return 404/403 and UI tabs/menu entries are hidden by view composers and middleware.

## Usage
- Web UI is available under `/communities` with channel and DM pages, reusing the host layout.
- API endpoints live under `/api` and require auth; see `API.md` for details.
- Flutter addon integration guidance is in `FLUTTER.md`.

## Testing
- Package-level PHPUnit tests ship under `tests/` (orchestra/testbench)
- Flutter package includes widget/model tests under `communities_addon/test`

## Support
Review `EVENTS.md` for hooks and listen to domain events to extend behavior. Check `FRONTEND.md` for Blade/JS structure.
