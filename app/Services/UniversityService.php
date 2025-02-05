<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\UniversityRepositoryInterface;
use App\Support\Interfaces\Services\UniversityServiceInterface;

class UniversityService extends BaseCrudService implements UniversityServiceInterface {
    protected function getRepositoryClass(): string {
        return UniversityRepositoryInterface::class;
    }
}