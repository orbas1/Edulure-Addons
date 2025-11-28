import 'package:equatable/equatable.dart';
import 'upload_attachment.dart';

class DMMessage extends Equatable {
  const DMMessage({
    required this.id,
    required this.threadId,
    required this.userId,
    required this.content,
    required this.createdAt,
    this.attachments = const [],
    this.metadata = const <String, dynamic>{},
  });

  factory DMMessage.fromJson(Map<String, dynamic> json) {
    return DMMessage(
      id: json['id'] as int,
      threadId: json['thread_id'] as int? ?? json['threadId'] as int? ?? 0,
      userId: json['user_id'] as int? ?? json['userId'] as int? ?? 0,
      content: json['content'] as String? ?? '',
      createdAt: DateTime.parse(json['created_at'] as String? ?? DateTime.now().toIso8601String()),
      attachments: (json['attachments'] as List<dynamic>? ?? [])
          .map((e) => UploadAttachment.fromJson(e as Map<String, dynamic>))
          .toList(),
      metadata: (json['metadata'] as Map<String, dynamic>?) ?? <String, dynamic>{},
    );
  }

  final int id;
  final int threadId;
  final int userId;
  final String content;
  final DateTime createdAt;
  final List<UploadAttachment> attachments;
  final Map<String, dynamic> metadata;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'thread_id': threadId,
        'user_id': userId,
        'content': content,
        'created_at': createdAt.toIso8601String(),
        'attachments': attachments.map((e) => e.toJson()).toList(),
        'metadata': metadata,
      };

  @override
  List<Object?> get props => [id, threadId, userId, content, createdAt, attachments, metadata];
}
