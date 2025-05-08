<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum SptModelEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case NORMAL = 'NORMAL';
    
    case PEMBETULAN = 'PEMBETULAN';
}