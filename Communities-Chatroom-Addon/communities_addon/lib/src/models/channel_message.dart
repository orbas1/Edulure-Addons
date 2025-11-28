import 'package:equatable/equatable.dart';
import 'channel_message_reaction.dart';
import 'upload_attachment.dart';

class ChannelMessage extends Equatable {
  const ChannelMessage({
    required this.id,
    required this.channelId,
    required this.userId,
    required this.content,
    required this.createdAt,
    this.metadata = const <String, dynamic>{},
    this.reactions = const [],
    this.attachments = const [],
    this.isPinned = false,
    this.isDeleted = false,
  });

  factory ChannelMessage.fromJson(Map<String, dynamic> json) {
    return ChannelMessage(
      id: json['id'] as int,
      channelId: json['channel_id'] as int? ?? json['channelId'] as int? ?? 0,
      userId: json['user_id'] as int? ?? json['userId'] as int? ?? 0,
      content: json['content'] as String? ?? '',
      createdAt: DateTime.parse(json['created_at'] as String? ?? DateTime.now().toIso8601String()),
      metadata: (json['metadata'] as Map<String, dynamic>?) ?? <String, dynamic>{},
      reactions: (json['reactions'] as List<dynamic>? ?? [])
          .map((e) => ChannelMessageReaction.fromJson(e as Map<String, dynamic>))
          .toList(),
      attachments: (json['attachments'] as List<dynamic>? ?? [])
          .map((e) => UploadAttachment.fromJson(e as Map<String, dynamic>))
          .toList(),
      isPinned: json['is_pinned'] as bool? ?? json['isPinned'] as bool? ?? false,
      isDeleted: json['is_deleted'] as bool? ?? json['isDeleted'] as bool? ?? false,
    );
  }

  final int id;
  final int channelId;
  final int userId;
  final String content;
  final DateTime createdAt;
  final Map<String, dynamic> metadata;
  final List<ChannelMessageReaction> reactions;
  final List<UploadAttachment> attachments;
  final bool isPinned;
  final bool isDeleted;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'channel_id': channelId,
        'user_id': userId,
        'content': content,
        'metadata': metadata,
        'is_pinned': isPinned,
        'is_deleted': isDeleted,
        'created_at': createdAt.toIso8601String(),
        'attachments': attachments.map((e) => e.toJson()).toList(),
        'reactions': reactions.map((e) => e.toJson()).toList(),
      };

  @override
  List<Object?> get props => [id, channelId, userId, content, createdAt, metadata, isPinned, isDeleted];
}
