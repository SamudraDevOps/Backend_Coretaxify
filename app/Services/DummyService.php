<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\DummyRepositoryInterface;
use App\Support\Interfaces\Services\DummyServiceInterface;

class DummyService extends BaseCrudService implements DummyServiceInterface {
    protected function getRepositoryClass(): string {
        return DummyRepositoryInterface::class;
    }
}