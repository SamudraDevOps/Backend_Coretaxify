<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\ProfilSayaRepositoryInterface;
use App\Support\Interfaces\Services\ProfilSayaServiceInterface;

class ProfilSayaService extends BaseCrudService implements ProfilSayaServiceInterface {
    protected function getRepositoryClass(): string {
        return ProfilSayaRepositoryInterface::class;
    }
}