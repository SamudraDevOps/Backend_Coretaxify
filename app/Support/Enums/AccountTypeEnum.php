<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum AccountTypeEnum: string {
    use Arrayable;

    case ORANG_PRIBADI = 'Orang Pribadi';
    case ORANG_PRIBADI_LAWAN_TRANSAKSI = 'Orang Pribadi Lawan Transaksi';
    case BADAN = 'Badan';
    case BADAN_LAWAN_TRANSAKSI = 'Badan Lawan Transaksi';
}