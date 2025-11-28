<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityCourse extends Model
{
    protected $table = 'community_courses';

    protected $fillable = [
        'community_id',
        'course_id',
        'link_type',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
