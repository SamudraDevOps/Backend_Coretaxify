<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SatuanRepositoryInterface;
use App\Support\Interfaces\Services\SatuanServiceInterface;

class SatuanService extends BaseCrudService implements SatuanServiceInterface {
    protected function getRepositoryClass(): string {
        return SatuanRepositoryInterface::class;
    }
}