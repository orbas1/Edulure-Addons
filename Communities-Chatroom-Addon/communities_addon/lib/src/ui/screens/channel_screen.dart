import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../repositories/channels_repository.dart';
import '../../state/channel_messages_cubit.dart';
import '../widgets/message_bubble.dart';

class ChannelScreen extends StatelessWidget {
  const ChannelScreen({super.key, required this.channelId, required this.channelName});

  final int channelId;
  final String channelName;

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (_) => ChannelMessagesCubit(ChannelsRepository(CommunitiesApiClient()))..load(channelId),
      child: Scaffold(
        appBar: AppBar(title: Text(channelName)),
        body: Column(
          children: [
            Expanded(
              child: BlocBuilder<ChannelMessagesCubit, ChannelMessagesState>(
                builder: (context, state) {
                  if (state.status == ChannelMessagesStatus.loading) {
                    return const Center(child: CircularProgressIndicator());
                  }
                  if (state.status == ChannelMessagesStatus.loaded) {
                    return ListView.builder(
                      padding: const EdgeInsets.all(12),
                      itemCount: state.messages.length,
                      itemBuilder: (context, index) => MessageBubble(message: state.messages[index]),
                    );
                  }
                  return Center(child: Text(state.errorMessage ?? 'Failed to load messages'));
                },
              ),
            ),
            _Composer(channelId: channelId),
          ],
        ),
      ),
    );
  }
}

class _Composer extends StatefulWidget {
  const _Composer({required this.channelId});

  final int channelId;

  @override
  State<_Composer> createState() => _ComposerState();
}

class _ComposerState extends State<_Composer> {
  final _controller = TextEditingController();

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Row(
        children: [
          Expanded(
            child: Padding(
              padding: const EdgeInsets.all(8.0),
              child: TextField(
                controller: _controller,
                decoration: const InputDecoration(hintText: 'Message'),
                minLines: 1,
                maxLines: 4,
              ),
            ),
          ),
          IconButton(
            icon: const Icon(Icons.send),
            onPressed: () {
              final text = _controller.text.trim();
              if (text.isEmpty) return;
              context.read<ChannelMessagesCubit>().postMessage(widget.channelId, text);
              _controller.clear();
            },
          ),
        ],
      ),
    );
  }
}
