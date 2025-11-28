import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/communities_repository.dart';
import '../repositories/channels_repository.dart';

part 'community_detail_state.dart';

class CommunityDetailCubit extends Cubit<CommunityDetailState> {
  CommunityDetailCubit(this._communitiesRepository, this._channelsRepository)
      : super(CommunityDetailState.initial());

  final CommunitiesRepository _communitiesRepository;
  final ChannelsRepository _channelsRepository;

  Future<void> load(int communityId) async {
    emit(state.copyWith(status: CommunityDetailStatus.loading));
    try {
      final community = await _communitiesRepository.fetchCommunity(communityId);
      final channels = await _channelsRepository.fetchChannels(communityId);
      emit(state.copyWith(status: CommunityDetailStatus.loaded, community: community, channels: channels));
    } catch (e) {
      emit(state.copyWith(status: CommunityDetailStatus.error, errorMessage: e.toString()));
    }
  }
}
