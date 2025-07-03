<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum JenisSptPphUnifikasiEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case DAFTAR_1 = 'DAFTAR-1';

    case DAFTAR_2 = 'DAFTAR-2';

    case LAMPIRAN_1 = 'LAMPIRAN-1';
}