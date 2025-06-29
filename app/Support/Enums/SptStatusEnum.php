<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum SptStatusEnum: string {
    use Arrayable;

    case KONSEP = 'KONSEP';

    case DILAPORKAN = 'DILAPORKAN';

    case DIBUAT = 'DIBUAT';

    case DIBATALKAN = 'DIBATALKAN';

    case DITOLAK = 'DITOLAK';

    case MENUNGGU_PEMBAYARAN = 'MENUNGGU_PEMBAYARAN';
}
