import 'package:equatable/equatable.dart';
import 'dm_message.dart';

enum DMThreadType { dm, group }

DMThreadType _threadTypeFrom(String? raw) {
  switch (raw) {
    case 'group':
      return DMThreadType.group;
    case 'dm':
    default:
      return DMThreadType.dm;
  }
}

String _threadTypeToString(DMThreadType type) {
  switch (type) {
    case DMThreadType.group:
      return 'group';
    case DMThreadType.dm:
    default:
      return 'dm';
  }
}

class DMThread extends Equatable {
  const DMThread({
    required this.id,
    required this.type,
    required this.createdBy,
    required this.participantIds,
    this.title,
    this.lastMessageAt,
    this.lastMessage,
  });

  factory DMThread.fromJson(Map<String, dynamic> json) {
    return DMThread(
      id: json['id'] as int,
      type: _threadTypeFrom(json['type'] as String?),
      createdBy: json['created_by'] as int? ?? json['createdBy'] as int? ?? 0,
      participantIds: (json['participants'] as List<dynamic>? ?? json['participant_ids'] as List<dynamic>? ?? json['participantIds'] as List<dynamic>? ?? [])
          .map((e) => e as int)
          .toList(),
      title: json['title'] as String?,
      lastMessageAt: json['last_message_at'] != null
          ? DateTime.tryParse(json['last_message_at'] as String)
          : null,
      lastMessage: json['last_message'] != null
          ? DMMessage.fromJson(json['last_message'] as Map<String, dynamic>)
          : null,
    );
  }

  final int id;
  final DMThreadType type;
  final int createdBy;
  final List<int> participantIds;
  final String? title;
  final DateTime? lastMessageAt;
  final DMMessage? lastMessage;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'type': _threadTypeToString(type),
        'created_by': createdBy,
        'participant_ids': participantIds,
        'title': title,
        'last_message_at': lastMessageAt?.toIso8601String(),
        'last_message': lastMessage?.toJson(),
      };

  @override
  List<Object?> get props => [id, type, createdBy, participantIds, title, lastMessageAt, lastMessage];
}
