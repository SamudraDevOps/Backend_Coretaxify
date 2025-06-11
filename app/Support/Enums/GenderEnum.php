<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum GenderEnum: string {
    use Arrayable;

    case L = 'Laki-laki';
    case P = 'Perempuan';
    case O = 'Lainnya';
}
