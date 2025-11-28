import 'package:equatable/equatable.dart';
import 'community_pricing_tier.dart';
import 'community_membership.dart';

enum CommunityVisibility { public, private, hidden }

CommunityVisibility _visibilityFrom(String? value) {
  switch (value) {
    case 'private':
      return CommunityVisibility.private;
    case 'hidden':
      return CommunityVisibility.hidden;
    default:
      return CommunityVisibility.public;
  }
}

String _visibilityToString(CommunityVisibility value) {
  switch (value) {
    case CommunityVisibility.private:
      return 'private';
    case CommunityVisibility.hidden:
      return 'hidden';
    case CommunityVisibility.public:
    default:
      return 'public';
  }
}

class Community extends Equatable {
  const Community({
    required this.id,
    required this.name,
    required this.description,
    required this.ownerId,
    required this.visibility,
    this.coverImage,
    this.icon,
    this.memberCount = 0,
    this.activityScore,
    this.pricingTiers = const [],
    this.membership,
  });

  factory Community.fromJson(Map<String, dynamic> json) {
    return Community(
      id: json['id'] as int,
      name: json['name'] as String? ?? '',
      description: json['description'] as String? ?? '',
      ownerId: json['owner_id'] as int? ?? json['ownerId'] as int? ?? 0,
      visibility: _visibilityFrom(json['visibility'] as String?),
      coverImage: json['cover_image_path'] as String? ?? json['cover_image'] as String?,
      icon: json['icon_path'] as String? ?? json['icon'] as String?,
      memberCount: json['member_count'] as int? ?? json['memberCount'] as int? ?? 0,
      activityScore: (json['activity_score'] as num?)?.toDouble(),
      pricingTiers: (json['pricing_tiers'] as List<dynamic>? ?? json['pricingTiers'] as List<dynamic>? ?? [])
          .map((e) => CommunityPricingTier.fromJson(e as Map<String, dynamic>))
          .toList(),
      membership: json['membership'] != null
          ? CommunityMembership.fromJson(json['membership'] as Map<String, dynamic>)
          : null,
    );
  }

  final int id;
  final String name;
  final String description;
  final int ownerId;
  final CommunityVisibility visibility;
  final String? coverImage;
  final String? icon;
  final int memberCount;
  final double? activityScore;
  final List<CommunityPricingTier> pricingTiers;
  final CommunityMembership? membership;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'name': name,
        'description': description,
        'owner_id': ownerId,
        'visibility': _visibilityToString(visibility),
        'cover_image_path': coverImage,
        'icon_path': icon,
        'member_count': memberCount,
        'activity_score': activityScore,
        'pricing_tiers': pricingTiers.map((e) => e.toJson()).toList(),
        'membership': membership?.toJson(),
      };

  @override
  List<Object?> get props => [id, name, visibility, ownerId, membership, memberCount];
}
