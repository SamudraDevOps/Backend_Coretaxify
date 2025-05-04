<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SptRepositoryInterface;
use App\Support\Interfaces\Services\SptServiceInterface;

class SptService extends BaseCrudService implements SptServiceInterface {
    protected function getRepositoryClass(): string {
        return SptRepositoryInterface::class;
    }
}