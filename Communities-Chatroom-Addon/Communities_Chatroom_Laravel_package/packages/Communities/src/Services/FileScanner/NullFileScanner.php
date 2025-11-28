<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services\FileScanner;

use Illuminate\Database\Eloquent\Model;
use RocketAddons\Communities\Models\FileScanJob;

class NullFileScanner implements FileScannerInterface
{
    public function queueScanForAttachment(Model $attachment): void
    {
        FileScanJob::create([
            'attachment_type' => $attachment->getTable(),
            'attachment_id' => $attachment->getKey(),
            'status' => 'done',
            'result' => ['driver' => 'null', 'status' => 'skipped'],
        ]);
    }
}
