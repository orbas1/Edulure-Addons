<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityHeatmap extends Model
{
    protected $table = 'activity_heatmaps';

    protected $fillable = [
        'user_id',
        'community_id',
        'date',
        'hourly_counts',
    ];

    protected $casts = [
        'date' => 'date',
        'hourly_counts' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'user_id');
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
