<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\JenisPajakRepositoryInterface;
use App\Support\Interfaces\Services\JenisPajakServiceInterface;

class JenisPajakService extends BaseCrudService implements JenisPajakServiceInterface {
    protected function getRepositoryClass(): string {
        return JenisPajakRepositoryInterface::class;
    }
}