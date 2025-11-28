import 'package:flutter/material.dart';

import '../../models/community.dart';
import '../screens/community_detail_screen.dart';

class CommunityCard extends StatelessWidget {
  const CommunityCard({super.key, required this.community});

  final Community community;

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
      child: ListTile(
        leading: const CircleAvatar(child: Icon(Icons.group)),
        title: Text(community.name),
        subtitle: Text(community.description),
        trailing: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            const Icon(Icons.people),
            Text(community.memberCount.toString()),
          ],
        ),
        onTap: () => Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => CommunityDetailScreen(communityId: community.id)),
        ),
      ),
    );
  }
}
