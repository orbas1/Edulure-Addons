import 'package:flutter/material.dart';

import '../../models/leaderboard_entry.dart';

class LeaderboardView extends StatelessWidget {
  const LeaderboardView({super.key, required this.entries});

  final List<LeaderboardEntry> entries;

  @override
  Widget build(BuildContext context) {
    return ListView.separated(
      itemCount: entries.length,
      separatorBuilder: (_, __) => const Divider(height: 1),
      itemBuilder: (context, index) {
        final entry = entries[index];
        return ListTile(
          leading: CircleAvatar(child: Text('${entry.rank}')),
          title: Text(entry.displayName ?? 'User ${entry.userId}'),
          subtitle: Text('Points: ${entry.points} • Level ${entry.level}'),
        );
      },
    );
  }
}
