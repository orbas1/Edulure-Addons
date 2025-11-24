# Agent Instructions – Communities & Chatroom Package (Laravel + Flutter)

## Overall Goal

Your goal is to create **one coherent addon** composed of:

1. A **Laravel package** (backend + web UI)
2. A **Flutter mobile addon package** (client UI + logic)

that together provide aligned functionality on both:

* The **Laravel backend / web app**, and
* The **Flutter mobile app**.

This addon plugs into an existing **RocketLMS** installation and evolves it towards a **community-first, Skool/Discord-style experience** while still remaining a classic LMS at its core.

It must behave as an **addon wrapper** that **extends** RocketLMS without overriding, breaking, or tightly coupling to core behaviour.

The addon brings together, under a single, consistent domain model:

1. **Communities**
2. **Chatroom**
3. **Leaderboards & Gamification**
4. **DMs & Moderation**

Concretely, the addon must deliver:

1. **Leaderboard**
2. **Central Feed – community feed** (with optional integration with existing forum; can coexist)
3. **Channels** (sub-spaces inside communities)
4. **Gamification** (points, badges, levels)
5. **DMs** (direct messages and small group DMs)
6. **Community “heat map”** (engagement visualisation per community/member)
7. **Community setup wizard & management**
8. **Community pricing tiers** (free/paid tiers, RocketLMS checkout integration)
9. **Community ↔ Courses connection** (attach communities to courses, live classes, bundles)
10. **Chatroom: Discord-style real-time chat**
    * Text channels, announcement/broadcast channels
    * Channel groups (categories)
    * Roles and permissions
    * Emojis / reactions
11. **File upload virus & malware scanning** (backend scanning pipeline)
12. **Content moderation**:
    * Bad word filter
    * Auto-flagging
    * Soft/hard bans and mutes

> ⚠️ Important: **Do not copy any binary files** (e.g. images, fonts, compiled assets, `.exe`, `.dll`, `.so`, APKs, etc.). Only copy **source code, configuration, Blade templates, Dart code**, and other text assets.  
>
> ⚠️ Important: Assume RocketLMS already provides core features (users, roles, auth, courses, lessons, payments, notifications, basic forums). You must build **on top of** these, using **new namespaced code, config flags and adapters**, not by renaming or deleting existing core logic.

---

## Integration Principles

1. **Non-invasive extension**
   * The package lives under its own namespace, e.g.:
     * PHP: `App\Addons\Communities`, or `RocketAddons\Communities`
     * Views: `resources/views/addons/communities/...`
   * No edits to RocketLMS core files. Use:
     * Service providers
     * Event listeners
     * Route macros
     * Config hooks
     * View composers
   * Where integration into existing UI is required (menus, course pages), do it via:
     * Blade components
     * Configurable include hooks
     * Middleware / view composers
     * Publishable view overrides **only if strictly necessary**, with clear documentation.

2. **Clear boundaries & domains**
   * Split logic into clear domains:
     * `Communities` (community, channels, membership, pricing tiers)
     * `Chat` (chatrooms, messages, threads, DMs)
     * `Gamification` (points, badges, levels, leaderboards, heatmap)
     * `Moderation` (reports, bans, mutes, bad words, audit log)
     * `Security` (file scanning, rate limiting, spam filtering)
   * Keep each domain in its own sub-namespace and directory tree.

3. **Single source of truth for users & identities**
   * All user accounts, authentication and core profile data come from **RocketLMS core User model**.
   * Do **not** create a new User entity. Instead:
     * Reference `users.id` as foreign key.
     * Extend via `CommunityProfile` / `GamificationProfile` models, keyed to `user_id`.
   * Respect RocketLMS roles/permissions and extend them with community-specific role mappings.

4. **Symmetry between web & mobile**
   * Backend APIs are the **single source of truth** for:
     * Communities
     * Channels
     * Feeds
     * Leaderboards
     * DMs
     * Gamification status
   * Web (Blade) and Flutter must consume the same API contract where possible.
   * Any logic implemented in Flutter must map to server-side concepts (no “mobile-only” features that aren’t backed by the API).

5. **Configurable & optional**
   * The addon must be **enable/disable-able** via a single config flag, e.g.:
     * `communities.enabled`
   * Individual features must be togglable:
     * `communities.chat.enabled`
     * `communities.gamification.enabled`
     * `communities.dm.enabled`
     * `communities.pricing.enabled`
   * All routes, menu entries and UI elements must check config flags (and license checks, if used).

6. **Security first**
   * Use RocketLMS’ existing auth middleware and CSRF protection.
   * Implement:
     * Rate limiting for posting messages, DMs, and file uploads.
     * Server-side validation for all inputs.
     * File upload scanning (configurable scanning backend: ClamAV, HTTP scanner, or “null” for dev).
     * Bad-word filter on server side (with configurable word lists).
     * Per-community and per-channel ACLs based on:
       * Global roles (Admin, Instructor, Student)
       * Community roles (Owner, Moderator, Member, Muted, Banned)
   * Ensure **no** unauthenticated access to private communities, channels, or DMs.

7. **Analytics & observability**
   * Add a small, consistent event-logging layer:
     * `CommunityJoined`, `MessagePosted`, `DMStarted`, `FileFlagged`, `UserBanned`, etc.
   * Store relevant metrics summarised in:
     * `community_activity_stats`
     * `user_activity_stats`
   * Provide daily/weekly aggregates for:
     * Active members per community
     * Messages sent
     * Top contributors (leaderboards)
     * Heatmap data (activity per day/hour per user/community)
   * Expose minimal, safe analytics endpoints for mobile and admin dashboards.

---

## Part 1 – Laravel Package

### 1. Config

Create a configuration file: `config/communities.php`

It must cover:

* **Global enable/disable**
  * `enabled` (bool)
* **Feature toggles**
  * `features`:
    * `leaderboard` (bool)
    * `central_feed` (bool)
    * `channels` (bool)
    * `gamification` (bool)
    * `dm` (bool)
    * `heatmap` (bool)
    * `pricing_tiers` (bool)
    * `chatroom` (bool)
    * `file_scanning` (bool)
    * `bad_word_filter` (bool)
* **Integration with RocketLMS**
  * `user_model` (class string, default to `App\Models\User`)
  * `course_model` (class string)
  * `payment_gateway_adapter` (class or enum; e.g. wrapper to reuse RocketLMS checkout)
  * `notification_channel` (e.g. use RocketLMS notification system)
* **Chat transport**
  * `chat`:
    * `driver` = `broadcast` | `pusher` | `redis` | `database`
    * `broadcast_channel_prefix` = string
    * `max_message_length`
    * `max_attachments_per_message`
* **File scanning**
  * `file_scanner`:
    * `driver` = `clamav` | `http` | `null`
    * `clamav` host/port
    * `http` URL/token
    * `allowed_mimetypes`
    * `max_file_size`
* **Bad word filter**
  * `moderation`:
    * `bad_words` = array or path to wordlist
    * `replace_char` (e.g. `*`)
    * `actions`:
      * `on_detect` = `censor` | `reject` | `flag`
      * `auto_mute_threshold`
      * `auto_ban_threshold`
* **Gamification**
  * `gamification`:
    * `points` for:
      * `post_message`
      * `reply_message`
      * `receive_reaction`
      * `start_dm`
      * `join_community`
      * `complete_course_in_linked_community`
    * `level_thresholds`
* **Pricing tiers**
  * `pricing`:
    * `enable_per_community_subscriptions` (bool)
    * `default_currency`
    * `gateways` mapping to RocketLMS’ existing payment method IDs.

### 2. Database

Design migrations and seeders to support the new domain.

**Core Tables (Communities & Channels)**

1. `communities`
   * `id`
   * `owner_id` (FK → users)
   * `slug` (unique)
   * `name`
   * `description`
   * `visibility` (`public`, `private`, `hidden`)
   * `cover_image_path` (nullable)
   * `icon_path` (nullable)
   * `default_role_id` (FK → community_roles)
   * `status` (`active`, `archived`)
   * `is_featured` (bool)
   * `settings` (JSON; e.g. enabling chat, DMs, etc.)
   * Timestamps

2. `community_courses`
   * `id`
   * `community_id`
   * `course_id` (FK → RocketLMS course)
   * `link_type` (`primary`, `related`, `live_classroom`)
   * Timestamps

3. `community_members`
   * `id`
   * `community_id`
   * `user_id`
   * `role_id` (FK → community_roles)
   * `joined_at`
   * `last_seen_at`
   * `status` (`active`, `muted`, `banned`, `pending`)
   * `ban_reason` (nullable)
   * `ban_expires_at` (nullable)

4. `community_roles`
   * `id`
   * `community_id` (nullable for global defaults)
   * `name` (Owner, Moderator, Member, Guest, etc.)
   * `slug`
   * `permissions` (JSON; e.g. `["manage_channels", "post", "pin_messages"]`)

5. `community_pricing_tiers`
   * `id`
   * `community_id`
   * `name` (Free, Pro, VIP, etc.)
   * `slug`
   * `description`
   * `price`
   * `currency`
   * `billing_interval` (`monthly`, `yearly`, `once`)
   * `features` (JSON; feature flags for that tier)
   * `is_default`
   * `is_active`
   * Timestamps

6. `community_member_subscriptions`
   * `id`
   * `community_id`
   * `user_id`
   * `pricing_tier_id`
   * `status` (`active`, `past_due`, `canceled`, `expired`)
   * `started_at`
   * `expires_at`
   * `external_subscription_id` (if linked to RocketLMS order)
   * Timestamps

**Chat & Feed**

7. `channels`
   * `id`
   * `community_id`
   * `parent_id` (nullable, for categories)
   * `name`
   * `slug`
   * `type` (`text`, `announcement`, `voice_future`, etc.)
   * `position`
   * `is_private`
   * `settings` (JSON; allowed roles, slow mode, etc.)
   * Timestamps

8. `channel_messages`
   * `id`
   * `channel_id`
   * `user_id`
   * `content` (text)
   * `metadata` (JSON; e.g. reply_to, mentions)
   * `is_pinned` (bool)
   * `is_deleted` (soft delete)
   * Timestamps

9. `channel_message_reactions`
   * `id`
   * `message_id`
   * `user_id`
   * `emoji` (string or code)
   * Timestamps

10. `channel_message_attachments`
    * `id`
    * `message_id`
    * `path`
    * `original_name`
    * `mime_type`
    * `size`
    * `scan_status` (`pending`, `clean`, `infected`, `failed`)
    * `scan_report` (JSON)
    * Timestamps

11. `central_feed_items`
    * `id`
    * `community_id` (nullable for global feed)
    * `user_id`
    * `type` (`post`, `announcement`, `course_event`, `system`)
    * `title` (nullable)
    * `content`
    * `metadata` (JSON)
    * `visibility`
    * Timestamps

12. `central_feed_reactions`
    * `id`
    * `feed_item_id`
    * `user_id`
    * `reaction` (emoji or enum)
    * Timestamps

13. `central_feed_comments`
    * `id`
    * `feed_item_id`
    * `user_id`
    * `content`
    * `metadata` (JSON)
    * Timestamps

**DMs**

14. `dm_threads`
    * `id`
    * `created_by` (user_id)
    * `type` (`dm`, `group`)
    * `title` (nullable; for groups)
    * `last_message_at`
    * Timestamps

15. `dm_participants`
    * `id`
    * `thread_id`
    * `user_id`
    * `role` (`owner`, `member`)
    * `joined_at`
    * `left_at` (nullable)

16. `dm_messages`
    * `id`
    * `thread_id`
    * `user_id`
    * `content`
    * `metadata`
    * `is_deleted`
    * Timestamps

17. `dm_message_attachments`
    * As per `channel_message_attachments`.

**Gamification & Leaderboard**

18. `gamification_profiles`
    * `id`
    * `user_id`
    * `total_points`
    * `level`
    * `xp`
    * `last_awarded_at`
    * `settings` (JSON)
    * Timestamps

19. `gamification_events`
    * `id`
    * `user_id`
    * `community_id` (nullable)
    * `type` (`message_posted`, `dm_sent`, `course_completed`, etc.)
    * `points`
    * `metadata` (JSON)
    * `occurred_at`
    * Timestamps

20. `leaderboard_snapshots`
    * `id`
    * `community_id` (nullable for global)
    * `period` (`daily`, `weekly`, `monthly`, `all_time`)
    * `starts_at`
    * `ends_at`
    * `data` (JSON; precomputed ranking)
    * Timestamps

21. `activity_heatmaps`
    * `id`
    * `user_id`
    * `community_id`
    * `date`
    * `hourly_counts` (JSON[24] or similar)
    * Timestamps

**Moderation**

22. `moderation_reports`
    * `id`
    * `reporter_id`
    * `target_type` (`channel_message`, `feed_item`, `dm_message`, `user`)
    * `target_id`
    * `reason`
    * `status` (`open`, `reviewing`, `resolved`, `dismissed`)
    * `assigned_to` (moderator_id, nullable)
    * `resolution_notes`
    * Timestamps

23. `bad_words`
    * `id`
    * `word`
    * `severity` (`low`, `medium`, `high`)
    * `replacement` (nullable)

24. `user_moderation_actions`
    * `id`
    * `user_id`
    * `community_id` (nullable)
    * `action` (`mute`, `ban`, `warning`)
    * `reason`
    * `expires_at` (nullable)
    * `performed_by`
    * Timestamps

**File Scanning Queue**

25. Either reuse Laravel’s built-in jobs table or add:
    * `file_scan_jobs`
      * `id`
      * `attachment_type` (`channel`, `dm`)
      * `attachment_id`
      * `status` (`pending`, `running`, `done`, `failed`)
      * `result` (JSON)
      * Timestamps

### 3. Domains

Organise PHP domains roughly like:

* `src/Communities/` – community, membership, pricing tiers, feed
* `src/Chat/` – channels, messages, DMs, attachments
* `src/Gamification/` – points, levels, leaderboards, heatmap
* `src/Moderation/` – reports, bans, filters
* `src/Security/` – scanners, rate limiting helpers
* `src/Http/Controllers/...`
* `src/Http/Resources/...`
* `src/Policies/...`
* `src/Events` / `Listeners`

Key domain models and responsibilities:

1. **CommunityManager**
   * Create/update/delete communities.
   * Attach/detach courses.
   * Assign owners/moderators/members.
   * Apply community settings and pricing tiers.

2. **MembershipService**
   * Join/leave community.
   * Gate joining based on:
     * Pricing tier
     * Instructor approval (if configured)
   * Sync membership state with RocketLMS enrolments where applicable.

3. **ChannelService**
   * Manage channels & categories (groups).
   * Enforce permissions per role (who can post, manage, etc.).
   * Provide list of channels per community and user access.

4. **ChatService**
   * Post/edit/delete messages.
   * Handle reactions.
   * Queue attachments for scanning.
   * Emit broadcast events (for real-time updates).

5. **DMService**
   * Create DM threads.
   * Invite/remove participants from group DMs.
   * Post messages, manage attachments.

6. **GamificationService**
   * Award points based on configured rules.
   * Calculate level progression.
   * Generate leaderboards; write snapshots.

7. **HeatmapService**
   * Aggregate events into hourly/day buckets.
   * Provide API to fetch heatmaps per user and/or per community.

8. **ModerationService**
   * Manage reports.
   * Apply auto actions (mute/ban) when thresholds reached.
   * Apply bad-word filter on messages and feed posts.
   * Expose admin/moderator workflows.

9. **FileScanner**
   * Abstract scanning backend.
   * Provide `scanAttachment()` which:
     * Pushes to queue
     * Updates attachment status
     * Deletes/quarantines infected files if configured.

---

### 6. Resources (Blade Views)

Provide Blade views/components for:

1. **Community index & discovery**
   * `/communities`
   * Filters: category, price (free/paid), activity, joined/not joined.
   * Cards showing:
     * Name, description
     * Member count
     * Activity indicator
     * Pricing tag (Free / £X/month)

2. **Community home**
   * Tabs:
     * `Feed`
     * `Channels`
     * `Members`
     * `Courses`
     * `Leaderboard`
     * `Settings` (for owner/mods)
   * Central feed view with:
     * List of `central_feed_items`
     * Inline reactions & comments
   * Sidebar:
     * Quick community info
     * Join/Leave button or subscription status.

3. **Channel view**
   * Slack/Discord-style layout:
     * Left sidebar: channel list grouped by category
     * Main area: messages
     * Composer at bottom
   * Support:
     * Reactions
     * Reply threading (lightweight via “reply to” metadata)
     * Attachments (file previews where possible)

4. **DM view**
   * Inbox: list of DM threads.
   * Conversation view: messages with attachments.

5. **Leaderboards & Gamification**
   * Per-community leaderboard page + widget:
     * Top users with avatar, name, points, level.
   * Global leaderboard (optional).
   * Gamification profile panel in user profile (points, badges, recent achievements).

6. **Heatmap**
   * Visual calendar or grid showing activity:
     * Days vs intensity
   * Per user and per community.

7. **Admin/owner settings**
   * Community creation & edit wizard:
     * Basic info
     * Cover & icon upload
     * Visibility & roles
     * Pricing tiers (if enabled)
     * Course linking
   * Moderation panel:
     * Open reports
     * Bans/mutes list
   * Analytics:
     * Summary stats (messages, new members, top contributors).

Views should be modular Blade components so they can be included in RocketLMS layouts via:

```php
@include('addons.communities.components.community-card', [...])


7. Admin Panel Entries

Integrate into RocketLMS admin area (or create an Addons section) with:

Menu entries:

Communities

Overview

Settings

Moderation

Gamification

Permissions:

manage_communities

manage_community_settings

view_community_analytics

manage_community_moderation

Admin screens:

Global Settings

Feature toggles.

Chat driver, scanning config, moderation defaults.

Community Management

List all communities.

Edit/impersonate owner (for support).

Moderation Center

List/open/close reports.

View flagged content.

Gamification Settings

Configure point values and level thresholds.

8. Assets (CSS/JS)

Provide separate asset bundles:

public/vendor/communities/css/communities.css

public/vendor/communities/js/communities.js

Use:

Tailwind/utility classes if RocketLMS uses them, or

A small, scoped stylesheet namespace (.communities-...) to avoid clashes.

JS:

Real-time chat:

Hook into Laravel Echo / Pusher or other broadcast driver.

Infinite scroll / pagination for feed and messages.

Emojis picker UI (JS-only, no binary emoji assets).

9. Language Translations

Provide translation files:

resources/lang/en/communities.php

Use standard Laravel translation helpers:

__('communities.join'), etc.

All user-facing text in the package must be translatable.

10. Routes

Group routes under:

Web routes, e.g. routes/communities_web.php

API routes, e.g. routes/communities_api.php

Prefix:

Web: /communities/...

API: /api/communities/...

Examples:

Web:

GET /communities – community index

GET /communities/{community} – community home

GET /communities/{community}/channels/{channel} – channel view

GET /dm – DM inbox

GET /dm/{thread} – DM thread

API:

GET /api/communities – list communities

POST /api/communities – create (owner/admin only)

POST /api/communities/{id}/join

POST /api/communities/{id}/leave

GET /api/communities/{id}/feed

POST /api/communities/{id}/feed

GET /api/channels/{id}/messages

POST /api/channels/{id}/messages

POST /api/channels/{id}/messages/{message}/react

POST /api/dm/threads

GET /api/dm/threads

GET /api/dm/threads/{id}/messages

POST /api/dm/threads/{id}/messages

GET /api/communities/{id}/leaderboard

GET /api/users/{id}/heatmap

All API routes must be authenticated (JWT/session) and return JSON resources.

11. Services & Support

Provide:

Facades for main services (e.g. Community, Chat, Gamification).

Event listeners for RocketLMS events (e.g. course completed ⇒ award points, add to feed).

Write:

Policies for models (CommunityPolicy, ChannelPolicy, etc.).

Middleware if needed (e.g. check membership before accessing a community route).

12. Service Provider

Create a main service provider, e.g. CommunitiesServiceProvider that:

Merges config communities.php.

Registers:

Routes

Views

Translations

Binds interfaces to implementations (e.g. FileScannerInterface).

Publishes:

Config

Migrations

Views

Assets

Ensure it checks the enabled flag and early-outs if the addon is disabled.

13. Documentation

Create AGENTS.md (this file) plus:

README.md – how to install, configure and use.

API.md – document all mobile/web API endpoints and payloads.

MIGRATIONS.md – list tables, relations and expected indexes.

EVENTS.md – list domain events for other addons to hook into.

Part 2 – Flutter Addon Package

The Flutter addon must provide client-side support for all pillars using the same backend API.

Package name suggestion: communities_addon (or similar).

1. pubspec.yaml

Declare:

Dependencies on:

HTTP client (e.g. dio or http)

State management library (e.g. flutter_bloc or riverpod)

WebSocket or socket client for real-time (if used)

JSON serialisation (e.g. json_serializable)

Expose a configurable base URL and auth token provider (to plug into existing RocketLMS app auth).

2. Models

Mirror all relevant backend entities:

Community

CommunityMembership

CommunityPricingTier

Channel

ChannelMessage

ChannelMessageReaction

DMThread

DMMessage

GamificationProfile

LeaderboardEntry

HeatmapPoint

ModerationReport

UploadAttachment (with scan status)

Use:

fromJson / toJson methods consistent with API responses.

Null-safe Dart code.

3. Screens / Pages

Provide modular widgets/screens, not a whole app:

CommunityListScreen

Lists communities.

Search, filters, join/leave buttons.

CommunityDetailScreen

Tabs:

Feed – central feed

Channels

Courses

Leaderboard

Members

Shows community metadata and join/subscription status.

ChannelScreen

Real-time chat UI:

Message list

Composer (text, emoji, file attachment)

Reactions

Handles:

Pagination/infinite scroll

Live updates via WebSocket or polling.

DMInboxScreen & DMThreadScreen

DM list with last message preview.

Conversation view with attachments & reactions.

LeaderboardScreen

List of top users with points and levels.

HeatmapView

Visual component rendering activity intensities.

CommunitySettingsScreen (optional, for owner/mod)

Manage community info, pricing tiers and roles (if owner/mod).

Only show if user has the right permissions (from API).

5. State Management

Use a consistent pattern (e.g. BLoC or Riverpod):

CommunityCubit / CommunityController

ChannelMessagesCubit

DMThreadsCubit

GamificationCubit

ModerationCubit

Responsibilities:

Fetch data from API.

Handle loading/error/success states.

Apply optimistic updates where safe (e.g. posting a message before server confirmation, then updating status).

6. menu.dart

Expose a small integration API so the existing RocketLMS mobile app can embed screens:

Provide:

A List<MenuItem> or similar structure, where MenuItem defines:

icon

label

route/builder

Example:

Communities main menu entry.

Optional Messages menu entry for DMs.

Integration must be opt-in and configurable via:

A class like CommunitiesAddonConfig that the host app initialises.

7. Analytics & Security Hooks (Client-Side)

Log client-side events (screen views, taps) and forward to any existing analytics.

Locally:

Enforce max message length.

Do quick bad-word checks if word list is shipped to mobile (optional, server is still source of truth).

Fail gracefully if:

API returns 403/401 (show friendly message, redirect to login).

Feature is disabled on server (hide menu entries/screens).

Required Functional Areas (Both Laravel & Flutter)

Below are the explicit functional requirements that must be implemented consistently across Laravel (backend/web) and Flutter (mobile) layers.

Leaderboard

Track user points from:

Messages in channels

DM activity (optionally lower weight)

Feed posts

Course completion in linked communities

Allow:

Global leaderboard

Per-community leaderboard

Period filters (weekly, monthly, all-time).

Provide:

API endpoints

Web Blade view

Flutter screen/widget.

Central Feed – communities feed

Provide a centralised feed per community (and optional global feed), separate from but potentially linked to RocketLMS forum.

Allow:

Posts (text + attachments)

Reactions (like/emojis)

Comments (threaded)

Optionally:

Show system events (new course in community, live class scheduled, etc.).

You may:

Keep RocketLMS forum intact.

Optionally expose forum threads inside the feed via adapters if desired (non-breaking).

Channels

Within each community:

Configure channels with types:

Standard text channel

Announcement/broadcast channel

Group channels into categories.

Enforce:

Per-channel visibility & permissions.

Provide:

Web chat UI

Mobile chat UI

APIs & broadcast events.

Gamification

Award points for:

Participation in chat/feed.

Helping others (e.g. answers marked helpful).

Community milestones (e.g. joining early).

Course completion in linked communities.

Maintain:

Levels

Badges (optional; definable in config).

Expose:

User profile gamification info

Community & global leaderboards.

DMs

One-to-one and small group DMs.

Support:

Text messages

File attachments

Reactions

Respect:

Global user block/mute settings if they exist.

Provide:

Web DM interface

Mobile DM screens

API and notifications.

Communities “heat map”

Track and aggregate user activity over time.

Provide:

GET /api/users/{id}/heatmap and optionally per-community heatmaps.

Visualise:

In web UI as calendar/grid.

In mobile UI as a heatmap component.

Community setup

Wizard for creating a community:

Basic details

Visibility

Channel defaults (e.g. #general, #announcements)

Pricing tiers (if enabled)

Linked courses.

Editing for owners/admins:

Community detail updates

Channel management

Member management & roles.

Community pricing tiers

Allow community owners/admins to define:

Free tier

Paid tiers with different benefits.

Integrate with RocketLMS payment system:

Use existing checkout & orders.

Map completed orders to community_member_subscriptions.

Enforce:

Access restrictions to communities/channels based on active subscription/tier.

Community ↔ Courses connection

Allow linking:

Course(s) to community.

Community chat to:

Course viewer

Live classroom.

UX:

From course page, show a “Go to community” or “Course chat” button.

From community, show attached courses and quick access.

Chat room: Discord-style integration

Real-time chat engine within RocketLMS:

Text channels, DM threads, etc.

Features:

Typing indicators (optional)

Read receipts (optional)

Replies, mentions (@user)

Emojis/reactions

Roles & permissions:

Channel & community roles define what each user can do.

Architecture:

REST API for history.

Broadcast/WebSocket for real-time events.

File upload virus & malware scanning

All community/chat uploads:

Must be scanned on the backend.

Workflow:

Upload goes to temporary storage.

Queue scan job.

If clean: mark as clean and retain.

If infected: mark as infected and prevent download (or delete).

Support:

Configurable scanner backend via file_scanner config.

Error handling & logging.

Bad word moderation & banning

Implement server-side filter:

Check messages and feed posts against wordlist.

Apply actions from config:

Censor

Reject

Flag to moderation queue

Track:

Violations per user.

Apply sanctions:

Automatic mute or ban when thresholds hit.

Provide:

Admin view for bad words.

Admin view of sanctions applied.