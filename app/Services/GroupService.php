<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\GroupRepositoryInterface;
use App\Support\Interfaces\Services\GroupServiceInterface;

class GroupService extends BaseCrudService implements GroupServiceInterface {
    protected function getRepositoryClass(): string {
        return GroupRepositoryInterface::class;
    }
}