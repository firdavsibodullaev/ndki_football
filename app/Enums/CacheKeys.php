<?php

namespace App\Enums;

use App\Traits\CacheTrait;

enum CacheKeys: string
{
    use CacheTrait;

    case TEAM = 'team';
}