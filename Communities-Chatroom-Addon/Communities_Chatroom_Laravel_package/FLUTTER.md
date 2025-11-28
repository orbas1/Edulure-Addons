# Flutter Addon Integration

Package location: `communities_addon/`

## Setup
1. Add a path dependency in the host app `pubspec.yaml`:
   ```yaml
   dependencies:
     communities_addon:
       path: ../Communities-Chatroom-Addon/communities_addon
   ```
2. Initialize config early (after auth ready):
   ```dart
   CommunitiesAddon.configure(
     CommunitiesAddonConfig(
       baseUrl: 'https://yourdomain.com',
       tokenProvider: () async => await authRepository.currentToken(),
     ),
   );
   ```
3. Register routes/menu items:
   ```dart
   final items = buildCommunitiesMenuItems();
   // add to your drawer/tab bar

   onGenerateRoute: communitiesOnGenerateRoute,
   ```

## Provided UI
- `CommunityListScreen`, `CommunityDetailScreen`
- `ChannelScreen` with composer + reactions
- `DMInboxScreen` and `DMThreadScreen`
- `LeaderboardScreen` and reusable `HeatmapView`

## State Management
BLoC cubits live under `lib/src/state/` and rely on repositories that wrap `CommunitiesApiClient` (Dio + bearer token from `tokenProvider`).

## Tests
Run Dart tests from the package root:
```bash
flutter test
```
