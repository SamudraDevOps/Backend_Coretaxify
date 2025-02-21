<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\DataEkonomiRepositoryInterface;
use App\Support\Interfaces\Services\DataEkonomiServiceInterface;

class DataEkonomiService extends BaseCrudService implements DataEkonomiServiceInterface {
    protected function getRepositoryClass(): string {
        return DataEkonomiRepositoryInterface::class;
    }
}