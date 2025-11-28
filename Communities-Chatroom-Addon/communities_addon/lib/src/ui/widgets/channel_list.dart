import 'package:flutter/material.dart';

import '../../models/channel.dart';

class ChannelList extends StatelessWidget {
  const ChannelList({super.key, required this.channels, required this.onTap});

  final List<Channel> channels;
  final void Function(Channel) onTap;

  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      itemCount: channels.length,
      itemBuilder: (context, index) {
        final channel = channels[index];
        return ListTile(
          leading: Icon(channel.type == ChannelType.announcement ? Icons.campaign : Icons.tag),
          title: Text(channel.name),
          onTap: () => onTap(channel),
        );
      },
    );
  }
}
