import 'package:flutter_test/flutter_test.dart';
import 'package:communities_addon/src/models/community.dart';
import 'package:communities_addon/src/models/community_membership.dart';
import 'package:communities_addon/src/models/community_pricing_tier.dart';

void main() {
  test('community serializes from json', () {
    final community = Community.fromJson({
      'id': 1,
      'name': 'Demo',
      'slug': 'demo',
      'description': 'Hello',
      'visibility': 'public',
      'settings': {'welcome': true},
      'memberships': [
        {
          'user_id': 5,
          'community_id': 1,
          'role': 'member',
          'status': 'active',
          'joined_at': '2024-01-01T00:00:00Z'
        }
      ],
      'pricing_tiers': [
        {
          'id': 9,
          'community_id': 1,
          'name': 'Free',
          'slug': 'free',
          'description': 'default',
          'price': 0,
          'currency': 'USD',
          'billing_interval': 'once',
          'features': {},
          'is_default': true,
          'is_active': true
        }
      ],
    });

    expect(community.id, 1);
    expect(community.memberships.first.status, CommunityMembershipStatus.active);
    expect(community.pricingTiers.first.billingInterval, BillingInterval.once);
    expect(community.toJson()['name'], 'Demo');
  });
}
