<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\KodeKluRepositoryInterface;
use App\Support\Interfaces\Services\KodeKluServiceInterface;

class KodeKluService extends BaseCrudService implements KodeKluServiceInterface {
    protected function getRepositoryClass(): string {
        return KodeKluRepositoryInterface::class;
    }
}