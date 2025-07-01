<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SptUnifikasiRepositoryInterface;
use App\Support\Interfaces\Services\SptUnifikasiServiceInterface;

class SptUnifikasiService extends BaseCrudService implements SptUnifikasiServiceInterface {
    protected function getRepositoryClass(): string {
        return SptUnifikasiRepositoryInterface::class;
    }
}