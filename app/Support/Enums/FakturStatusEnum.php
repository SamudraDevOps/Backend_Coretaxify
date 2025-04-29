<?php

namespace App\Support\Enums;

use App\Traits\Enums\Arrayable;
// use App\Traits\Enums\Translatable;

enum FakturStatusEnum: string {
    // use Arrayable, Translatable;
    use Arrayable;

    case APPROVED = 'APPROVED';

    case CANCELED = 'CANCELED';

    case AMENDED = 'AMENDED';

    case DRAFT = 'DRAFT';
}
