<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\PenunjukkanWajibPajakSayaRepositoryInterface;
use App\Support\Interfaces\Services\PenunjukkanWajibPajakSayaServiceInterface;

class PenunjukkanWajibPajakSayaService extends BaseCrudService implements PenunjukkanWajibPajakSayaServiceInterface {
    protected function getRepositoryClass(): string {
        return PenunjukkanWajibPajakSayaRepositoryInterface::class;
    }
}