import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../repositories/dm_repository.dart';
import '../../state/dm_threads_cubit.dart';
import 'dm_thread_screen.dart';

class DMInboxScreen extends StatelessWidget {
  const DMInboxScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (_) => DMThreadsCubit(DMRepository(CommunitiesApiClient()))..load(),
      child: Scaffold(
        appBar: AppBar(title: const Text('Messages')),
        body: BlocBuilder<DMThreadsCubit, DMThreadsState>(
          builder: (context, state) {
            if (state.status == DMThreadsStatus.loading) {
              return const Center(child: CircularProgressIndicator());
            }
            if (state.status == DMThreadsStatus.loaded) {
              return ListView.builder(
                itemCount: state.threads.length,
                itemBuilder: (context, index) {
                  final thread = state.threads[index];
                  return ListTile(
                    title: Text(thread.title ?? 'Direct message'),
                    subtitle: Text('Participants: ${thread.participantIds.join(', ')}'),
                    onTap: () => Navigator.push(
                      context,
                      MaterialPageRoute(builder: (_) => DMThreadScreen(threadId: thread.id)),
                    ),
                  );
                },
              );
            }
            return Center(child: Text(state.errorMessage ?? 'Unable to load threads'));
          },
        ),
        floatingActionButton: FloatingActionButton(
          onPressed: () => context.read<DMThreadsCubit>().createThread(const [], title: 'New thread'),
          child: const Icon(Icons.add_comment),
        ),
      ),
    );
  }
}
