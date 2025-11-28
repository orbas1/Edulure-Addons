import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/gamification_repository.dart';

part 'leaderboard_state.dart';

class LeaderboardCubit extends Cubit<LeaderboardState> {
  LeaderboardCubit(this._repository) : super(LeaderboardState.initial());

  final GamificationRepository _repository;

  Future<void> load(int communityId, {String? period}) async {
    emit(state.copyWith(status: LeaderboardStatus.loading));
    try {
      final entries = await _repository.fetchLeaderboard(communityId, period: period);
      emit(state.copyWith(status: LeaderboardStatus.loaded, entries: entries));
    } catch (e) {
      emit(state.copyWith(status: LeaderboardStatus.error, errorMessage: e.toString()));
    }
  }
}
