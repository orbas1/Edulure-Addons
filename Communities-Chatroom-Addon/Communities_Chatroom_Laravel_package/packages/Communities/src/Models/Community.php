<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{
    protected $table = 'communities';

    protected $fillable = [
        'owner_id',
        'slug',
        'name',
        'description',
        'visibility',
        'cover_image_path',
        'icon_path',
        'default_role_id',
        'status',
        'is_featured',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_featured' => 'boolean',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'owner_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(CommunityMember::class);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(CommunityRole::class);
    }

    public function pricingTiers(): HasMany
    {
        return $this->hasMany(CommunityPricingTier::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(CommunityCourse::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CommunityMemberSubscription::class);
    }
}
