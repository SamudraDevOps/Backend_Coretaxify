<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\TaskUserRepositoryInterface;
use App\Support\Interfaces\Services\TaskUserServiceInterface;

class TaskUserService extends BaseCrudService implements TaskUserServiceInterface {
    protected function getRepositoryClass(): string {
        return TaskUserRepositoryInterface::class;
    }
}