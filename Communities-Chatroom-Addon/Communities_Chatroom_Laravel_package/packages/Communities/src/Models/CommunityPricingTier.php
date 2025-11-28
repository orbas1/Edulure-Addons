<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityPricingTier extends Model
{
    protected $table = 'community_pricing_tiers';

    protected $fillable = [
        'community_id',
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_interval',
        'features',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
