<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface WakilSayaInformasiUmumServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data): ?Model;
}