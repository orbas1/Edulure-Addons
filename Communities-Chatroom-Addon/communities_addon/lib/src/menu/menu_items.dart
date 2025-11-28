import 'package:flutter/material.dart';

import '../ui/screens/community_list_screen.dart';
import '../ui/screens/dm_inbox_screen.dart';

class CommunitiesMenuItem {
  const CommunitiesMenuItem({required this.icon, required this.label, required this.routeName, required this.builder});

  final IconData icon;
  final String label;
  final String routeName;
  final WidgetBuilder builder;
}

List<CommunitiesMenuItem> buildCommunitiesMenuItems() {
  return const [
    CommunitiesMenuItem(
      icon: Icons.groups,
      label: 'Communities',
      routeName: '/communities',
      builder: (_) => CommunityListScreen(),
    ),
    CommunitiesMenuItem(
      icon: Icons.mail,
      label: 'Messages',
      routeName: '/dm',
      builder: (_) => DMInboxScreen(),
    ),
  ];
}
