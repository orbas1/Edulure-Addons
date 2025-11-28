<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModerationAction extends Model
{
    protected $table = 'user_moderation_actions';

    protected $fillable = [
        'user_id',
        'community_id',
        'action',
        'reason',
        'expires_at',
        'performed_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'performed_by');
    }
}
