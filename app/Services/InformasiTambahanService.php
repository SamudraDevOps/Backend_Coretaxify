<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\InformasiTambahanRepositoryInterface;
use App\Support\Interfaces\Services\InformasiTambahanServiceInterface;

class InformasiTambahanService extends BaseCrudService implements InformasiTambahanServiceInterface {
    protected function getRepositoryClass(): string {
        return InformasiTambahanRepositoryInterface::class;
    }
}