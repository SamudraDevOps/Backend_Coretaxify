<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\LectureTaskRepositoryInterface;
use App\Support\Interfaces\Services\LectureTaskServiceInterface;

class LectureTaskService extends BaseCrudService implements LectureTaskServiceInterface {
    protected function getRepositoryClass(): string {
        return LectureTaskRepositoryInterface::class;
    }
}