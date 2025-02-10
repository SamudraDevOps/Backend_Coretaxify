<?php

namespace App\Support\Interfaces\Services;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface GroupServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data): ?Model;

    public function joinGroup(array $data): ?Model;

    public function getGroupsByUserId($userId, $role = null);
}
