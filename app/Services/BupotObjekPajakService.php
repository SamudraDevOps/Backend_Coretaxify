<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotObjekPajakRepositoryInterface;
use App\Support\Interfaces\Services\BupotObjekPajakServiceInterface;

class BupotObjekPajakService extends BaseCrudService implements BupotObjekPajakServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotObjekPajakRepositoryInterface::class;
    }
}