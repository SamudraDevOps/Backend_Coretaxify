<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\KuasaWajibPajakRepositoryInterface;
use App\Support\Interfaces\Services\KuasaWajibPajakServiceInterface;

class KuasaWajibPajakService extends BaseCrudService implements KuasaWajibPajakServiceInterface {
    protected function getRepositoryClass(): string {
        return KuasaWajibPajakRepositoryInterface::class;
    }
}