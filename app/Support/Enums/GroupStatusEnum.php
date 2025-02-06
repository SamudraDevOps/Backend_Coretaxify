<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum GroupStatusEnum: string {
    use Arrayable;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}