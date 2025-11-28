import 'package:flutter/material.dart';

class CommunitySettingsScreen extends StatelessWidget {
  const CommunitySettingsScreen({super.key, required this.communityId});

  final int communityId;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Community Settings')),
      body: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Community #$communityId', style: Theme.of(context).textTheme.titleLarge),
            const SizedBox(height: 16),
            const Text('Owners can edit community name, description, visibility, and pricing tiers.'),
            const SizedBox(height: 24),
            TextFormField(decoration: const InputDecoration(labelText: 'Name')),
            TextFormField(decoration: const InputDecoration(labelText: 'Description')),
            DropdownButtonFormField<String>(
              value: 'public',
              items: const [
                DropdownMenuItem(value: 'public', child: Text('Public')),
                DropdownMenuItem(value: 'private', child: Text('Private')),
                DropdownMenuItem(value: 'hidden', child: Text('Hidden')),
              ],
              onChanged: (_) {},
              decoration: const InputDecoration(labelText: 'Visibility'),
            ),
            const SizedBox(height: 24),
            ElevatedButton(onPressed: () {}, child: const Text('Save changes')),
          ],
        ),
      ),
    );
  }
}
