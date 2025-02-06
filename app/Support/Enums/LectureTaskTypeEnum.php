<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum LectureTaskTypeEnum: string {
    use Arrayable;

    case PRAKTIKUM = 'PRAKTIKUM';
    case UJIAN = 'UJIAN';
    case BNSP = 'BNSP';
}