<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\PortalSayaRepositoryInterface;
use App\Support\Interfaces\Services\PortalSayaServiceInterface;

class PortalSayaService extends BaseCrudService implements PortalSayaServiceInterface {
    protected function getRepositoryClass(): string {
        return PortalSayaRepositoryInterface::class;
    }
}