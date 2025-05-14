<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum JenisPajakEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case PPN = 'PPN';

    case PPH = 'PPH';

    case PPH_UNIFIKASI = 'PPHUNIFIKASI';

    case PPH_BADAN = 'PPHBADAN';
}