<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DMMessage extends Model
{
    protected $table = 'dm_messages';

    protected $fillable = [
        'thread_id',
        'user_id',
        'content',
        'metadata',
        'is_deleted',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_deleted' => 'boolean',
    ];

    public function thread(): BelongsTo
    {
        return $this->belongsTo(DMThread::class, 'thread_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(DMMessageAttachment::class, 'message_id');
    }
}
