<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services\FileScanner;

use Illuminate\Database\Eloquent\Model;

interface FileScannerInterface
{
    public function queueScanForAttachment(Model $attachment): void;
}
