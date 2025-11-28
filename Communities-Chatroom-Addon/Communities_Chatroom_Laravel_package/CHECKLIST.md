# Implementation Checklist (per AGENTS.md)

- Communities: Models/Migrations (`Community`), API (`CommunityController@index/store`), Blade (`communities/index`, `communities/show`), Flutter (`CommunityListScreen`).
- Central feed: API (`/communities/{id}/feed`), Blade partial (`feed-tab`), JS reactions, Flutter detail tab placeholder.
- Channels/chat: Models (`Channel`, `ChannelMessage`), API routes guarded by `communities.membership`, Blade channel UI, Flutter `ChannelScreen`.
- DMs: API (`DMController`), Blade DM pages, Flutter `DMInboxScreen`/`DMThreadScreen`.
- Leaderboards/gamification: Services (`GamificationService`), API (`LeaderboardController`), Blade leaderboard tab, Flutter `LeaderboardScreen`.
- Heatmaps: `HeatmapService`, API (`HeatmapController`), Blade heatmap pages, Flutter `HeatmapView` widget.
- Pricing tiers: Migration/model (`CommunityPricingTier`), Blade pricing cards, Flutter models.
- Course linking: `community_courses` migration/model, Blade courses tab.
- File scanning: Config + `FileScannerInterface` implementations, middleware/feature guard, attachment resources.
- Bad word moderation/bans: `bad_words` table, `ModerationController`, middleware guards, admin Blade views.
- Navigation/menu: View composer in `CommunitiesServiceProvider` to inject Communities/DM links.
