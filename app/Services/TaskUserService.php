<?php

namespace App\Services;

use App\Support\Interfaces\Services\TaskUserServiceInterface;
use App\Support\Interfaces\Repositories\TaskUserRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class TaskUserService extends BaseCrudService implements TaskUserServiceInterface {
    protected function getRepositoryClass(): string {
        return TaskUserRepositoryInterface::class;
    }
}