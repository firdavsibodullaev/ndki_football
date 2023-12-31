<?php

namespace App\Enums;

use App\Traits\CacheTrait;

enum CacheKeys: string
{
    use CacheTrait;

    case TEAM = 'team';
    case PLAYER = 'player';
    case SEASON = 'season';
    case TOURNAMENT = 'tournament';

    case GAME_ID = 'game-id';
    case USER = 'user';
}
