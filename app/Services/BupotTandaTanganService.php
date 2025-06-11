<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotTandaTanganRepositoryInterface;
use App\Support\Interfaces\Services\BupotTandaTanganServiceInterface;

class BupotTandaTanganService extends BaseCrudService implements BupotTandaTanganServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotTandaTanganRepositoryInterface::class;
    }
}