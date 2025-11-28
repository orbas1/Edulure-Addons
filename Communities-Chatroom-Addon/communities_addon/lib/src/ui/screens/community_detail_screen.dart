import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../../repositories/channels_repository.dart';
import '../../repositories/communities_repository.dart';
import '../../state/community_detail_cubit.dart';
import '../../state/leaderboard_cubit.dart';
import '../../state/heatmap_cubit.dart';
import '../widgets/channel_list.dart';
import '../widgets/community_overview.dart';
import '../widgets/leaderboard_view.dart';
import '../widgets/heatmap_view.dart';
import 'channel_screen.dart';
import 'leaderboard_screen.dart';

class CommunityDetailScreen extends StatelessWidget {
  const CommunityDetailScreen({super.key, required this.communityId});

  final int communityId;

  @override
  Widget build(BuildContext context) {
    final communityRepo = CommunitiesRepository(CommunitiesApiClient());
    final channelRepo = ChannelsRepository(CommunitiesApiClient());
    return MultiBlocProvider(
      providers: [
        BlocProvider(create: (_) => CommunityDetailCubit(communityRepo, channelRepo)..load(communityId)),
        BlocProvider(create: (_) => LeaderboardCubit(GamificationRepository(CommunitiesApiClient()))),
        BlocProvider(create: (_) => HeatmapCubit(AnalyticsRepository(CommunitiesApiClient()))),
      ],
      child: Scaffold(
        appBar: AppBar(title: const Text('Community')),
        body: BlocBuilder<CommunityDetailCubit, CommunityDetailState>(
          builder: (context, state) {
            if (state.status == CommunityDetailStatus.loading) {
              return const Center(child: CircularProgressIndicator());
            }
            if (state.status == CommunityDetailStatus.loaded && state.community != null) {
              return DefaultTabController(
                length: 5,
                child: Column(
                  children: [
                    CommunityOverview(community: state.community!),
                    const TabBar(
                      tabs: [
                        Tab(text: 'Feed'),
                        Tab(text: 'Channels'),
                        Tab(text: 'Leaderboard'),
                        Tab(text: 'Members'),
                        Tab(text: 'Heatmap'),
                      ],
                    ),
                    Expanded(
                      child: TabBarView(
                        children: [
                          const Center(child: Text('Feed coming from backend feed endpoint')),
                          ChannelList(
                            channels: state.channels,
                            onTap: (channel) => Navigator.push(
                              context,
                              MaterialPageRoute(builder: (_) => ChannelScreen(channelId: channel.id, channelName: channel.name)),
                            ),
                          ),
                          LeaderboardScreen(communityId: communityId),
                          Center(child: Text('Members count: ${state.community!.memberCount}')),
                          BlocBuilder<HeatmapCubit, HeatmapState>(
                            builder: (context, heatmapState) {
                              if (heatmapState.status == HeatmapStatus.initial) {
                                context.read<HeatmapCubit>().load(state.community!.ownerId);
                              }
                              if (heatmapState.status == HeatmapStatus.loading) {
                                return const Center(child: CircularProgressIndicator());
                              }
                              if (heatmapState.status == HeatmapStatus.loaded) {
                                return HeatmapView(points: heatmapState.points);
                              }
                              return Text(heatmapState.errorMessage ?? '');
                            },
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              );
            }
            return Center(child: Text(state.errorMessage ?? 'Unable to load community'));
          },
        ),
      ),
    );
  }
}
