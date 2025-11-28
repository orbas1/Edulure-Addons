<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DMThread extends Model
{
    protected $table = 'dm_threads';

    protected $fillable = [
        'created_by',
        'type',
        'title',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'created_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(DMParticipant::class, 'thread_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DMMessage::class, 'thread_id');
    }
}
