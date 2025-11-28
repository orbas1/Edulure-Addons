# Frontend (Blade + JS)

- Layouts under `resources/views/addons/communities/layouts/base.blade.php` wrap RocketLMS master layout.
- Main pages: communities index/show, channel view, DM inbox/thread, leaderboard, heatmap, admin dashboards.
- Components: community cards/badges, member lists, feed items/comments, pricing tier cards, pagination.
- JS entry: `public/vendor/communities/js/communities.js` exposes `window.Communities.Chat.initChannel(channelId, options)` for Echo subscriptions and basic message/reaction handling.
- CSS: `public/vendor/communities/css/communities.css` scoped with `.communities-*` classes.
- Feature toggles: Blade checks `config('communities.features.*')` to hide tabs/menus; middleware returns 404/403 when disabled.
