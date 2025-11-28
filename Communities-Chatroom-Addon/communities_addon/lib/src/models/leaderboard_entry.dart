import 'package:equatable/equatable.dart';
class LeaderboardEntry extends Equatable {
  const LeaderboardEntry({
    required this.userId,
    required this.rank,
    required this.points,
    required this.level,
    this.displayName,
    this.avatarUrl,
  });

  factory LeaderboardEntry.fromJson(Map<String, dynamic> json) {
    return LeaderboardEntry(
      userId: json['user_id'] as int? ?? json['userId'] as int? ?? 0,
      rank: json['rank'] as int? ?? 0,
      points: json['points'] as int? ?? 0,
      level: json['level'] as int? ?? 0,
      displayName: json['display_name'] as String? ?? json['displayName'] as String?,
      avatarUrl: json['avatar_url'] as String? ?? json['avatarUrl'] as String?,
    );
  }

  final int userId;
  final int rank;
  final int points;
  final int level;
  final String? displayName;
  final String? avatarUrl;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'user_id': userId,
        'rank': rank,
        'points': points,
        'level': level,
        'display_name': displayName,
        'avatar_url': avatarUrl,
      };

  @override
  List<Object?> get props => [userId, rank, points, level];
}
