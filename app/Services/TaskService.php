<?php

namespace App\Services;

use App\Support\Interfaces\Services\TaskServiceInterface;
use App\Support\Interfaces\Repositories\TaskRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class TaskService extends BaseCrudService implements TaskServiceInterface {
    protected function getRepositoryClass(): string {
        return TaskRepositoryInterface::class;
    }
}