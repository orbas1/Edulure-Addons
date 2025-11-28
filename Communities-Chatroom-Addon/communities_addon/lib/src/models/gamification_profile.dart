import 'package:equatable/equatable.dart';
class GamificationProfile extends Equatable {
  const GamificationProfile({
    required this.userId,
    required this.points,
    required this.level,
  });

  factory GamificationProfile.fromJson(Map<String, dynamic> json) {
    return GamificationProfile(
      userId: json['user_id'] as int? ?? json['userId'] as int? ?? 0,
      points: json['points'] as int? ?? 0,
      level: json['level'] as int? ?? 0,
    );
  }

  final int userId;
  final int points;
  final int level;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'user_id': userId,
        'points': points,
        'level': level,
      };

  @override
  List<Object?> get props => [userId, points, level];
}
