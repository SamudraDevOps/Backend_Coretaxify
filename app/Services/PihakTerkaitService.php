<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\PihakTerkaitRepositoryInterface;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;

class PihakTerkaitService extends BaseCrudService implements PihakTerkaitServiceInterface {
    protected function getRepositoryClass(): string {
        return PihakTerkaitRepositoryInterface::class;
    }
}