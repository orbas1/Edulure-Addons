<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Channel extends Model
{
    protected $table = 'channels';

    protected $fillable = [
        'community_id',
        'parent_id',
        'name',
        'slug',
        'type',
        'position',
        'is_private',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_private' => 'boolean',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Channel::class, 'parent_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChannelMessage::class);
    }
}
