<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModerationReport extends Model
{
    protected $table = 'moderation_reports';

    protected $fillable = [
        'reporter_id',
        'target_type',
        'target_id',
        'reason',
        'status',
        'assigned_to',
        'resolution_notes',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'reporter_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(config('communities.user_model'), 'assigned_to');
    }
}
