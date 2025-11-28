# Domain Events

| Event | When Fired | Useful For |
| --- | --- | --- |
| `CommunityJoined` | After a user joins a community via `MembershipService::joinCommunity` | Grant course enrolments, send welcome notifications |
| `ChannelMessagePosted` | After a channel message is stored in `ChatService` | Real-time broadcasting, heatmap/gamification updates |
| `DMMessagePosted` | After a DM message is stored | Push notifications, typing indicators |
| `FileScanCompleted` | After a scanner reports a result | Notify users about blocked files, audit logs |
| `UserBannedInCommunity` | When moderation bans a member | Force logout/kick from channels, analytics |

Listeners in the package already update heatmaps, award points, and trigger scanning. Other addons can subscribe via Laravel's event system or broadcasting.
