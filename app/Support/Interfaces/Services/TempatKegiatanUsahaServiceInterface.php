<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistem;

interface TempatKegiatanUsahaServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data, ?Sistem $sistem = null): ?Model;
}
