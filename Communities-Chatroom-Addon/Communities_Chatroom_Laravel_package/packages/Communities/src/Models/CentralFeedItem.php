<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CentralFeedItem extends Model
{
    protected $table = 'central_feed_items';

    protected $fillable = [
        'community_id',
        'user_id',
        'type',
        'title',
        'content',
        'metadata',
        'visibility',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(CentralFeedReaction::class, 'feed_item_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CentralFeedComment::class, 'feed_item_id');
    }
}
