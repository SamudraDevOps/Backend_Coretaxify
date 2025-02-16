<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\AlamatWajibPajakRepositoryInterface;
use App\Support\Interfaces\Services\AlamatWajibPajakServiceInterface;

class AlamatWajibPajakService extends BaseCrudService implements AlamatWajibPajakServiceInterface {
    protected function getRepositoryClass(): string {
        return AlamatWajibPajakRepositoryInterface::class;
    }
}