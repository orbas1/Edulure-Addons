<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChannelMessageAttachment extends Model
{
    protected $table = 'channel_message_attachments';

    protected $fillable = [
        'message_id',
        'path',
        'original_name',
        'mime_type',
        'size',
        'scan_status',
        'scan_report',
    ];

    protected $casts = [
        'scan_report' => 'array',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(ChannelMessage::class, 'message_id');
    }
}
