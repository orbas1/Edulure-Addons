part of 'heatmap_cubit.dart';

enum HeatmapStatus { initial, loading, loaded, error }

class HeatmapState extends Equatable {
  const HeatmapState({
    required this.status,
    this.points = const [],
    this.errorMessage,
  });

  factory HeatmapState.initial() => const HeatmapState(status: HeatmapStatus.initial);

  final HeatmapStatus status;
  final List<HeatmapPoint> points;
  final String? errorMessage;

  HeatmapState copyWith({HeatmapStatus? status, List<HeatmapPoint>? points, String? errorMessage}) {
    return HeatmapState(
      status: status ?? this.status,
      points: points ?? this.points,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  @override
  List<Object?> get props => [status, points, errorMessage];
}
