# Migrations Overview

| Table | Purpose |
| --- | --- |
| communities | Core community metadata, owner, visibility, settings |
| community_courses | Links RocketLMS courses to communities (primary/related/live_classroom) |
| community_members | Membership records, roles, statuses (active/muted/banned/pending) |
| community_roles | Global and per-community role definitions with permissions JSON |
| community_pricing_tiers | Paid/free tiers with pricing, currency, interval, feature flags |
| community_member_subscriptions | Tracks user subscriptions to community tiers |
| channels | Text/announcement channels with nesting, privacy, settings |
| channel_messages | Channel messages with metadata, soft deletes, pinned flag |
| channel_message_reactions | Emoji reactions with user/message associations |
| channel_message_attachments | Uploaded files plus scan status/report |
| central_feed_items | Feed posts/announcements scoped to community |
| central_feed_reactions | Emoji reactions for feed items |
| central_feed_comments | Comments on feed items |
| dm_threads | Direct/group message threads |
| dm_participants | Users in DM threads |
| dm_messages | Messages in DM threads |
| dm_message_attachments | Attachments for DMs |
| gamification_profiles | Stores accumulated points/levels per user |
| gamification_events | Logged events contributing to gamification |
| leaderboard_snapshots | Stored leaderboard aggregates for caching |
| activity_heatmaps | Aggregated hourly activity counts |
| moderation_reports | Bad word flags/moderation tickets |
| bad_words | Word list used by filter |
| user_moderation_actions | Audit of bans/mutes/warnings |
| file_scan_jobs | Optional tracking for queued scan results |

Indexes and foreign keys are defined per migration to maintain referential integrity and performance.
