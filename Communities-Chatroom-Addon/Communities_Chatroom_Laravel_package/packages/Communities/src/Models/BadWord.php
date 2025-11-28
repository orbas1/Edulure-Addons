<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Models;

use Illuminate\Database\Eloquent\Model;

class BadWord extends Model
{
    protected $table = 'bad_words';

    protected $fillable = [
        'word',
        'severity',
        'replacement',
    ];
}
