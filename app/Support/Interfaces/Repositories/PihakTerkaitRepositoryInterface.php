<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface PihakTerkaitRepositoryInterface extends BaseRepositoryInterface {
    public function getAllBySistemId(array $filters, int $sistemId): Collection;
}
