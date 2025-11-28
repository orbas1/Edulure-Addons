<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;

class FileScanJob extends Model
{
    protected $table = 'file_scan_jobs';

    protected $fillable = [
        'attachment_type',
        'attachment_id',
        'status',
        'result',
    ];

    protected $casts = [
        'result' => 'array',
    ];
}
