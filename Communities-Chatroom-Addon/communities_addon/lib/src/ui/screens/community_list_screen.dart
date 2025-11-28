import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../../communities_addon.dart';
import '../../repositories/communities_repository.dart';
import '../../state/communities_cubit.dart';
import '../widgets/community_card.dart';

class CommunityListScreen extends StatelessWidget {
  const CommunityListScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (_) => CommunitiesCubit(CommunitiesRepository(CommunitiesApiClient()))..loadCommunities(),
      child: Scaffold(
        appBar: AppBar(title: const Text('Communities')),
        body: BlocBuilder<CommunitiesCubit, CommunitiesState>(
          builder: (context, state) {
            if (state is CommunitiesLoading) {
              return const Center(child: CircularProgressIndicator());
            }
            if (state is CommunitiesLoaded) {
              return RefreshIndicator(
                onRefresh: () => context.read<CommunitiesCubit>().loadCommunities(),
                child: ListView.builder(
                  itemCount: state.communities.length,
                  itemBuilder: (context, index) => CommunityCard(community: state.communities[index]),
                ),
              );
            }
            if (state is CommunitiesError) {
              return Center(child: Text(state.message));
            }
            return const SizedBox.shrink();
          },
        ),
      ),
    );
  }
}
