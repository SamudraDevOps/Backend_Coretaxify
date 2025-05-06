<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum PTKPEnum: string {
    use Arrayable;

    case K0 = 'K/0';
    case K1 = 'K/1';
    case K2 = 'K/2';
    case K3 = 'K/3';
    case TK0 = 'TK/0';
    case TK1 = 'TK/1';
    case TK2 = 'TK/2';
    case TK3 = 'TK/3';
}
