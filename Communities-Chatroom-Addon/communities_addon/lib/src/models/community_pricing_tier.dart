import 'package:equatable/equatable.dart';
enum BillingInterval { monthly, yearly, once }

BillingInterval _billingIntervalFrom(String? raw) {
  switch (raw) {
    case 'yearly':
      return BillingInterval.yearly;
    case 'once':
      return BillingInterval.once;
    case 'monthly':
    default:
      return BillingInterval.monthly;
  }
}

String _billingIntervalToString(BillingInterval interval) {
  switch (interval) {
    case BillingInterval.yearly:
      return 'yearly';
    case BillingInterval.once:
      return 'once';
    case BillingInterval.monthly:
    default:
      return 'monthly';
  }
}

class CommunityPricingTier extends Equatable {
  const CommunityPricingTier({
    required this.id,
    required this.communityId,
    required this.name,
    required this.slug,
    required this.price,
    required this.currency,
    required this.billingInterval,
    this.description,
    this.isDefault = false,
    this.isActive = true,
    this.features = const <String, dynamic>{},
  });

  factory CommunityPricingTier.fromJson(Map<String, dynamic> json) {
    return CommunityPricingTier(
      id: json['id'] as int,
      communityId: json['community_id'] as int? ?? json['communityId'] as int? ?? 0,
      name: json['name'] as String? ?? '',
      slug: json['slug'] as String? ?? '',
      price: json['price'] as num? ?? 0,
      currency: json['currency'] as String? ?? 'USD',
      billingInterval: _billingIntervalFrom(json['billing_interval'] as String? ?? json['billingInterval'] as String?),
      description: json['description'] as String?,
      isDefault: json['is_default'] as bool? ?? json['isDefault'] as bool? ?? false,
      isActive: json['is_active'] as bool? ?? json['isActive'] as bool? ?? true,
      features: (json['features'] as Map<String, dynamic>?) ?? <String, dynamic>{},
    );
  }

  final int id;
  final int communityId;
  final String name;
  final String slug;
  final num price;
  final String currency;
  final BillingInterval billingInterval;
  final String? description;
  final bool isDefault;
  final bool isActive;
  final Map<String, dynamic> features;

  Map<String, dynamic> toJson() => <String, dynamic>{
        'id': id,
        'community_id': communityId,
        'name': name,
        'slug': slug,
        'price': price,
        'currency': currency,
        'billing_interval': _billingIntervalToString(billingInterval),
        'description': description,
        'is_default': isDefault,
        'is_active': isActive,
        'features': features,
      };

  @override
  List<Object?> get props => [id, communityId, name, price, currency, billingInterval];
}
