import 'package:flutter/material.dart';

import '../../models/channel_message.dart';
import '../../models/dm_message.dart';

class MessageBubble extends StatelessWidget {
  const MessageBubble({super.key, required this.message});

  final Object message;

  @override
  Widget build(BuildContext context) {
    final content = switch (message) {
      ChannelMessage m => m.content,
      DMMessage m => m.content,
      _ => '',
    };
    final isSelf = false;
    return Align(
      alignment: isSelf ? Alignment.centerRight : Alignment.centerLeft,
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 4),
        padding: const EdgeInsets.all(12),
        decoration: BoxDecoration(
          color: isSelf ? Colors.blue.shade100 : Colors.grey.shade200,
          borderRadius: BorderRadius.circular(12),
        ),
        child: Text(content),
      ),
    );
  }
}
