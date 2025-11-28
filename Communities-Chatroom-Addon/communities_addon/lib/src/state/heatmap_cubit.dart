import 'package:equatable/equatable.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import '../models/models.dart';
import '../repositories/analytics_repository.dart';

part 'heatmap_state.dart';

class HeatmapCubit extends Cubit<HeatmapState> {
  HeatmapCubit(this._repository) : super(HeatmapState.initial());

  final AnalyticsRepository _repository;

  Future<void> load(int userId) async {
    emit(state.copyWith(status: HeatmapStatus.loading));
    try {
      final points = await _repository.fetchUserHeatmap(userId);
      emit(state.copyWith(status: HeatmapStatus.loaded, points: points));
    } catch (e) {
      emit(state.copyWith(status: HeatmapStatus.error, errorMessage: e.toString()));
    }
  }
}
