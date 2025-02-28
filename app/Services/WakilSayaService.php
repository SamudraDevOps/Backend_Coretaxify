<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\WakilSayaRepositoryInterface;
use App\Support\Interfaces\Services\WakilSayaServiceInterface;

class WakilSayaService extends BaseCrudService implements WakilSayaServiceInterface {
    protected function getRepositoryClass(): string {
        return WakilSayaRepositoryInterface::class;
    }
}