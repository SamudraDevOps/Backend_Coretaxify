<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\KodeTransaksiRepositoryInterface;
use App\Support\Interfaces\Services\KodeTransaksiServiceInterface;

class KodeTransaksiService extends BaseCrudService implements KodeTransaksiServiceInterface {
    protected function getRepositoryClass(): string {
        return KodeTransaksiRepositoryInterface::class;
    }
}