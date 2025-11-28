import 'package:flutter/material.dart';

import '../../models/community.dart';

class CommunityOverview extends StatelessWidget {
  const CommunityOverview({super.key, required this.community});

  final Community community;

  @override
  Widget build(BuildContext context) {
    return ListTile(
      leading: const CircleAvatar(child: Icon(Icons.group_work)),
      title: Text(community.name, style: Theme.of(context).textTheme.titleLarge),
      subtitle: Text(community.description),
      trailing: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [Text('Members'), Text('${community.memberCount}')],
      ),
    );
  }
}
