import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../repositories/dm_repository.dart';
import '../../state/dm_thread_messages_cubit.dart';
import '../widgets/message_bubble.dart';

class DMThreadScreen extends StatelessWidget {
  const DMThreadScreen({super.key, required this.threadId});

  final int threadId;

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (_) => DMThreadMessagesCubit(DMRepository(CommunitiesApiClient()))..load(threadId),
      child: Scaffold(
        appBar: AppBar(title: const Text('Direct Message')),
        body: Column(
          children: [
            Expanded(
              child: BlocBuilder<DMThreadMessagesCubit, DMThreadMessagesState>(
                builder: (context, state) {
                  if (state.status == DMThreadMessagesStatus.loading) {
                    return const Center(child: CircularProgressIndicator());
                  }
                  if (state.status == DMThreadMessagesStatus.loaded) {
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
            _Composer(threadId: threadId),
          ],
        ),
      ),
    );
  }
}

class _Composer extends StatefulWidget {
  const _Composer({required this.threadId});

  final int threadId;

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
              context.read<DMThreadMessagesCubit>().postMessage(widget.threadId, text);
              _controller.clear();
            },
          ),
        ],
      ),
    );
  }
}
