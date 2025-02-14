<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\ExamUserRepositoryInterface;
use App\Support\Interfaces\Services\ExamUserServiceInterface;

class ExamUserService extends BaseCrudService implements ExamUserServiceInterface {
    protected function getRepositoryClass(): string {
        return ExamUserRepositoryInterface::class;
    }
}