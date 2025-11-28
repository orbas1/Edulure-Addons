<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GamificationProfile extends Model
{
    protected $table = 'gamification_profiles';

    protected $fillable = [
        'user_id',
        'total_points',
        'level',
        'xp',
        'last_awarded_at',
        'settings',
    ];

    protected $casts = [
        'last_awarded_at' => 'datetime',
        'settings' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(GamificationEvent::class, 'user_id');
    }
}
