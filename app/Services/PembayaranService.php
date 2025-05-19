<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\PembayaranRepositoryInterface;
use App\Support\Interfaces\Services\PembayaranServiceInterface;

class PembayaranService extends BaseCrudService implements PembayaranServiceInterface {
    protected function getRepositoryClass(): string {
        return PembayaranRepositoryInterface::class;
    }
}