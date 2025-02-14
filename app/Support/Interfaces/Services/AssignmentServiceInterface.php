<?php

namespace App\Support\Interfaces\Services;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface AssignmentServiceInterface extends BaseCrudServiceInterface {
    // public function create(array $data): ?Model;

    public function assignTask(array $data): ?Model;
}