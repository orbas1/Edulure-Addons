# API Endpoints
All routes require authentication and are wrapped with the `communities.enabled` middleware. Feature-specific endpoints also require their respective `communities.feature:*` middleware.

## Communities
- `GET /api/communities` — list communities (paginate)
- `POST /api/communities` — create a community (owners/admins)
- `POST /api/communities/{id}/join` — join a community
- `POST /api/communities/{id}/leave` — leave a community
- `GET /api/communities/{id}/feed` — central feed (requires membership, feature `central_feed`)
- `POST /api/communities/{id}/feed` — post to feed (requires membership, feature `central_feed`)

## Channels & Chat
- `GET /api/channels/{id}/messages` — message history (requires membership, feature `channels`)
- `POST /api/channels/{id}/messages` — post a message (requires membership)
- `POST /api/channels/{id}/messages/{message}/react` — toggle reaction

## Direct Messages
- `GET /api/dm/threads` — list DM threads (feature `dm`)
- `POST /api/dm/threads` — create thread
- `GET /api/dm/threads/{id}/messages` — list thread messages
- `POST /api/dm/threads/{id}/messages` — send DM

## Leaderboard & Heatmap
- `GET /api/communities/{id}/leaderboard?period=week|month|all` — leaderboard entries (feature `leaderboard`)
- `GET /api/users/{id}/heatmap` — user heatmap points (feature `heatmap`)

## Moderation
- `POST /api/moderation/reports` — create a moderation report/bad-word flag (feature `bad_word_filter`)

### Response Shapes
Most endpoints return dedicated API Resources:
- `CommunityResource`: `id`, `name`, `slug`, `description`, `visibility`, `settings`
- `ChannelResource`: `id`, `community_id`, `name`, `slug`, `type`, `is_private`, `settings`
- `ChannelMessageResource`: `id`, `channel_id`, `user_id`, `content`, `metadata`, `attachments`, `reactions`, `created_at`
- `DMThreadResource` and `DMMessageResource`: include participant IDs, latest message metadata
- `LeaderboardEntryResource`: `user_id`, `points`, `level`, `rank`
- `HeatmapResource`: `date`, `hourly_counts`

### Errors
- 404 when addon or feature disabled
- 403 when user not a member or is banned/muted
- 422 for validation errors

### Auth
The routes rely on existing RocketLMS authentication (`auth` middleware). For mobile clients, ensure the Sanctum/JWT guard used in RocketLMS is applied to `/api` routes.
