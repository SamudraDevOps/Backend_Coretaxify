<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\ObjekPajakBumiDanBangunanRepositoryInterface;
use App\Support\Interfaces\Services\ObjekPajakBumiDanBangunanServiceInterface;

class ObjekPajakBumiDanBangunanService extends BaseCrudService implements ObjekPajakBumiDanBangunanServiceInterface {
    protected function getRepositoryClass(): string {
        return ObjekPajakBumiDanBangunanRepositoryInterface::class;
    }
}