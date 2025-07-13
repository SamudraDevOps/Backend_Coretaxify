<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;

enum AssignmentTypeEnum: string
{
    use Arrayable;

    case ASSIGNMENT = 'assignment';
    case EXAM = 'exam';
}
