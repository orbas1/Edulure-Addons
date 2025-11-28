import 'package:equatable/equatable.dart';
enum ModerationStatus { open, resolved, actioned }
enum ModerationAction { warn, mute, ban, none }

ModerationStatus _moderationStatusFrom(String? raw) {
  switch (raw) {
    case 'resolved':
      return ModerationStatus.resolved;
    case 'actioned':
      return ModerationStatus.actioned;
    case 'open':
    default:
      return ModerationStatus.open;
  }
}

ModerationAction _moderationActionFrom(String? raw) {
  switch (raw) {
    case 'warn':
      return ModerationAction.warn;
    case 'mute':
      return ModerationAction.mute;
    case 'ban':
      return ModerationAction.ban;
    case 'none':
    default:
      return ModerationAction.none;
  }
}

String _moderationStatusToString(ModerationStatus status) {
  switch (status) {
    case ModerationStatus.resolved:
      return 'resolved';
    case ModerationStatus.actioned:
      return 'actioned';
    case ModerationStatus.open:
    default:
      return 'open';
  }
}

String _moderationActionToString(ModerationAction action) {
  switch (action) {
    case ModerationAction.warn:
      return 'warn';
    case ModerationAction.mute:
      return 'mute';
    case ModerationAction.ban:
      return 'ban';
    case ModerationAction.none:
    default:
      return 'none';
  }
}

class ModerationReport extends Equatable {
  const ModerationReport({
    required this.id,
    required this.communityId,
    required this.reporterId,
    required this.status,
    this.targetUserId,
    this.reason,
    this.action,
  });

  factory ModerationReport.fromJson(Map<String, dynamic> json) {
    return ModerationReport(
      id: json['id'] as int,
      communityId: json['community_id'] as int? ?? json['communityId'] as int? ?? 0,
      reporterId: json['reporter_id'] as int? ?? json['reporterId'] as int? ?? 0,
      status: _moderationStatusFrom(json['status'] as String?),
      targetUserId: json['target_user_id'] as int? ?? json['targetUserId'] as int?,
      reason: json['reason'] as String?,
      action: json['action'] != null ? _moderationActionFrom(json['action'] as String?) : null,
    );
  }

  final int id;
  final int communityId;
  final int reporterId;
  final int? targetUserId;
  final String? reason;
  final ModerationStatus status;
  final ModerationAction? action;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'community_id': communityId,
        'reporter_id': reporterId,
        'status': _moderationStatusToString(status),
        'target_user_id': targetUserId,
        'reason': reason,
        'action': action != null ? _moderationActionToString(action!) : null,
      };

  @override
  List<Object?> get props => [id, communityId, reporterId, status, targetUserId, reason, action];
}
