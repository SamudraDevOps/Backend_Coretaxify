<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum ContractStatusEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
