<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\GroupAssignmentRepositoryInterface;
use App\Support\Interfaces\Services\GroupAssignmentServiceInterface;

class GroupAssignmentService extends BaseCrudService implements GroupAssignmentServiceInterface {
    protected function getRepositoryClass(): string {
        return GroupAssignmentRepositoryInterface::class;
    }
}