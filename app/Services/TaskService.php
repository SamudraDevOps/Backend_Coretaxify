<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\TaskRepositoryInterface;
use App\Support\Interfaces\Services\TaskServiceInterface;

class TaskService extends BaseCrudService implements TaskServiceInterface {
    protected function getRepositoryClass(): string {
        return TaskRepositoryInterface::class;
    }
}