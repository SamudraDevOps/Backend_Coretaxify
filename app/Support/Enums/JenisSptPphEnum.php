<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum JenisSptPphEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case L1 = 'L1';

    case L3 = 'L3';
}
