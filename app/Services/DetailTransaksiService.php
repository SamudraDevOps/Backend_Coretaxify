<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\DetailTransaksiRepositoryInterface;
use App\Support\Interfaces\Services\DetailTransaksiServiceInterface;

class DetailTransaksiService extends BaseCrudService implements DetailTransaksiServiceInterface {
    protected function getRepositoryClass(): string {
        return DetailTransaksiRepositoryInterface::class;
    }
}