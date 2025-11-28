<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityMemberSubscription extends Model
{
    protected $table = 'community_member_subscriptions';

    protected $fillable = [
        'community_id',
        'user_id',
        'pricing_tier_id',
        'status',
        'started_at',
        'expires_at',
        'external_subscription_id',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function pricingTier(): BelongsTo
    {
        return $this->belongsTo(CommunityPricingTier::class, 'pricing_tier_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }
}
