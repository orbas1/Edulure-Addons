<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CentralFeedComment extends Model
{
    protected $table = 'central_feed_comments';

    protected $fillable = [
        'feed_item_id',
        'user_id',
        'content',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function feedItem(): BelongsTo
    {
        return $this->belongsTo(CentralFeedItem::class, 'feed_item_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }
}
