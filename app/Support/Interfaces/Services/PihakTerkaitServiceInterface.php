<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sistem;
use App\Models\Assignment;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface PihakTerkaitServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data , ?Sistem $sistem = null  ): ?Model;
}
