<?php

namespace App\DTOs;

use Illuminate\Contracts\Support\Arrayable;

abstract class BaseDTO implements Arrayable
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
