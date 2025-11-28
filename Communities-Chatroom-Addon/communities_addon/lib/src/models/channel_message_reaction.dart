import 'package:equatable/equatable.dart';
class ChannelMessageReaction extends Equatable {
  const ChannelMessageReaction({
    required this.emoji,
    required this.count,
    required this.reacted,
  });

  factory ChannelMessageReaction.fromJson(Map<String, dynamic> json) {
    return ChannelMessageReaction(
      emoji: json['emoji'] as String? ?? '',
      count: json['count'] as int? ?? 0,
      reacted: json['reacted'] as bool? ?? false,
    );
  }

  final String emoji;
  final int count;
  final bool reacted;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'emoji': emoji,
        'count': count,
        'reacted': reacted,
      };

  @override
  List<Object?> get props => [emoji, count, reacted];
}
