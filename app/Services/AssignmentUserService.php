<?php

namespace App\Services;

use App\Support\Interfaces\Services\AssignmentUserServiceInterface;
use App\Support\Interfaces\Repositories\AssignmentUserRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class AssignmentUserService extends BaseCrudService implements AssignmentUserServiceInterface {
    protected function getRepositoryClass(): string {
        return AssignmentUserRepositoryInterface::class;
    }
}
