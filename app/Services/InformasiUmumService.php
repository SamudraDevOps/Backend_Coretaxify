<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\InformasiUmumRepositoryInterface;
use App\Support\Interfaces\Services\InformasiUmumServiceInterface;

class InformasiUmumService extends BaseCrudService implements InformasiUmumServiceInterface {
    protected function getRepositoryClass(): string {
        return InformasiUmumRepositoryInterface::class;
    }
}