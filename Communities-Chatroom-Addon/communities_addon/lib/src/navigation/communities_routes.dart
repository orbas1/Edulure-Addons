import 'package:flutter/material.dart';

import '../ui/screens/channel_screen.dart';
import '../ui/screens/community_detail_screen.dart';
import '../ui/screens/community_list_screen.dart';
import '../ui/screens/dm_inbox_screen.dart';
import '../ui/screens/dm_thread_screen.dart';

class CommunitiesRoutes {
  static Route<dynamic>? onGenerateRoute(RouteSettings settings) {
    switch (settings.name) {
      case '/communities':
        return MaterialPageRoute(builder: (_) => const CommunityListScreen());
      case '/dm':
        return MaterialPageRoute(builder: (_) => const DMInboxScreen());
      case '/community':
        final id = settings.arguments as int;
        return MaterialPageRoute(builder: (_) => CommunityDetailScreen(communityId: id));
      case '/channel':
        final args = settings.arguments as Map<String, dynamic>;
        return MaterialPageRoute(
            builder: (_) => ChannelScreen(channelId: args['id'] as int, channelName: args['name'] as String));
      case '/dm/thread':
        final id = settings.arguments as int;
        return MaterialPageRoute(builder: (_) => DMThreadScreen(threadId: id));
    }
    return null;
  }
}
