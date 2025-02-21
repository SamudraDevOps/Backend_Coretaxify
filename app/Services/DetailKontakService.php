<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\DetailKontakRepositoryInterface;
use App\Support\Interfaces\Services\DetailKontakServiceInterface;

class DetailKontakService extends BaseCrudService implements DetailKontakServiceInterface {
    protected function getRepositoryClass(): string {
        return DetailKontakRepositoryInterface::class;
    }
}