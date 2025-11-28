import 'package:equatable/equatable.dart';
import 'community_pricing_tier.dart';

enum MembershipStatus { active, muted, banned, pending }

MembershipStatus _membershipStatusFrom(String? raw) {
  switch (raw) {
    case 'muted':
      return MembershipStatus.muted;
    case 'banned':
      return MembershipStatus.banned;
    case 'pending':
      return MembershipStatus.pending;
    case 'active':
    default:
      return MembershipStatus.active;
  }
}

String _membershipStatusToString(MembershipStatus status) {
  switch (status) {
    case MembershipStatus.muted:
      return 'muted';
    case MembershipStatus.banned:
      return 'banned';
    case MembershipStatus.pending:
      return 'pending';
    case MembershipStatus.active:
    default:
      return 'active';
  }
}

class CommunityMembership extends Equatable {
  const CommunityMembership({
    required this.communityId,
    required this.userId,
    required this.status,
    this.role,
    this.pricingTier,
    this.expiresAt,
  });

  factory CommunityMembership.fromJson(Map<String, dynamic> json) {
    return CommunityMembership(
      communityId: json['community_id'] as int? ?? json['communityId'] as int? ?? 0,
      userId: json['user_id'] as int? ?? json['userId'] as int? ?? 0,
      status: _membershipStatusFrom(json['status'] as String?),
      role: json['role'] as String?,
      pricingTier: json['pricing_tier'] != null
          ? CommunityPricingTier.fromJson(json['pricing_tier'] as Map<String, dynamic>)
          : null,
      expiresAt: json['expires_at'] != null
          ? DateTime.tryParse(json['expires_at'] as String)
          : null,
    );
  }

  final int communityId;
  final int userId;
  final MembershipStatus status;
  final String? role;
  final CommunityPricingTier? pricingTier;
  final DateTime? expiresAt;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'community_id': communityId,
        'user_id': userId,
        'status': _membershipStatusToString(status),
        'role': role,
        'pricing_tier': pricingTier?.toJson(),
        'expires_at': expiresAt?.toIso8601String(),
      };

  @override
  List<Object?> get props => [communityId, userId, status, role, pricingTier, expiresAt];
}
