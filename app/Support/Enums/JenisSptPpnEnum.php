<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum JenisSptPpnEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case A1 = 'A1';

    case A2 = 'A2';

    case B1 = 'B1';

    case B2 = 'B2';

    case B3 = 'B3';

    case C = 'C';
}