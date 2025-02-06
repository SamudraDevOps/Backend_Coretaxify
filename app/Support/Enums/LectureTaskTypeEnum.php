<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum LectureTaskTypeEnum: string {
    use Arrayable;

    case PRAKTIKUM = 'praktikum';
    case UJIAN = 'ujian';
    case BNSP = 'BNSP';
}