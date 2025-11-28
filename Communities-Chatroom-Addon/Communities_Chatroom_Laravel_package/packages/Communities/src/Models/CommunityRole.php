<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityRole extends Model
{
    protected $table = 'community_roles';

    protected $fillable = [
        'community_id',
        'name',
        'slug',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(CommunityMember::class, 'role_id');
    }
}
