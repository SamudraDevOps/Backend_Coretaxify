<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface ContractServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data): ?Model;
    public function update($keyOrModel, array $data): ?Model;
}
