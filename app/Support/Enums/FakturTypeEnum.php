<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum FakturTypeEnum: string {
    use Arrayable;

    case FAKTUR_MASUKAN = 'Faktur Masukan';
    case FAKTUR_KELUARAN = 'Faktur Keluaran';
    case RETUR_FAKTUR_MASUKAN = 'Retur Faktur Masukan';
    case RETUR_FAKTUR_KELUARAN = 'Retur Faktur Keluaran';
}
