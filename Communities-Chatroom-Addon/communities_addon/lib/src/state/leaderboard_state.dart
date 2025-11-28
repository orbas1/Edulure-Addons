part of 'leaderboard_cubit.dart';

enum LeaderboardStatus { initial, loading, loaded, error }

class LeaderboardState extends Equatable {
  const LeaderboardState({
    required this.status,
    this.entries = const [],
    this.errorMessage,
  });

  factory LeaderboardState.initial() => const LeaderboardState(status: LeaderboardStatus.initial);

  final LeaderboardStatus status;
  final List<LeaderboardEntry> entries;
  final String? errorMessage;

  LeaderboardState copyWith({LeaderboardStatus? status, List<LeaderboardEntry>? entries, String? errorMessage}) {
    return LeaderboardState(
      status: status ?? this.status,
      entries: entries ?? this.entries,
      errorMessage: errorMessage ?? this.errorMessage,
    );
  }

  @override
  List<Object?> get props => [status, entries, errorMessage];
}
