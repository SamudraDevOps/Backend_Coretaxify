<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SptPphRepositoryInterface;
use App\Support\Interfaces\Services\SptPphServiceInterface;

class SptPphService extends BaseCrudService implements SptPphServiceInterface {
    protected function getRepositoryClass(): string {
        return SptPphRepositoryInterface::class;
    }
}