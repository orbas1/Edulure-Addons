<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChannelMessage extends Model
{
    protected $table = 'channel_messages';

    protected $fillable = [
        'channel_id',
        'user_id',
        'content',
        'metadata',
        'is_pinned',
        'is_deleted',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_pinned' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ChannelMessageAttachment::class, 'message_id');
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(ChannelMessageReaction::class, 'message_id');
    }
}
