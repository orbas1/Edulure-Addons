import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../repositories/gamification_repository.dart';
import '../../state/leaderboard_cubit.dart';
import '../widgets/leaderboard_view.dart';

class LeaderboardScreen extends StatelessWidget {
  const LeaderboardScreen({super.key, required this.communityId});

  final int communityId;

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create: (_) => LeaderboardCubit(GamificationRepository(CommunitiesApiClient()))..load(communityId),
      child: Scaffold(
        appBar: AppBar(title: const Text('Leaderboard')),
        body: BlocBuilder<LeaderboardCubit, LeaderboardState>(
          builder: (context, state) {
            if (state.status == LeaderboardStatus.loading) {
              return const Center(child: CircularProgressIndicator());
            }
            if (state.status == LeaderboardStatus.loaded) {
              return LeaderboardView(entries: state.entries);
            }
            return Center(child: Text(state.errorMessage ?? 'Failed to load leaderboard'));
          },
        ),
      ),
    );
  }
}
