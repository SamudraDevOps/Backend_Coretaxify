<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SistemRepositoryInterface;
use App\Support\Interfaces\Services\SistemServiceInterface;

class SistemService extends BaseCrudService implements SistemServiceInterface {
    protected function getRepositoryClass(): string {
        return SistemRepositoryInterface::class;
    }
}