<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\GroupRepositoryInterface;
use App\Support\Interfaces\Services\GroupServiceInterface;

class GroupService extends BaseCrudService implements GroupServiceInterface {
    protected function getRepositoryClass(): string {
        return GroupRepositoryInterface::class;
    }

    public function create(array $data): ?Model {
        $data['class_code'] = Group::generateClassCode();
        return parent::create($data);
    }
}