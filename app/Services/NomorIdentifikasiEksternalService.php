<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\NomorIdentifikasiEksternalRepositoryInterface;
use App\Support\Interfaces\Services\NomorIdentifikasiEksternalServiceInterface;

class NomorIdentifikasiEksternalService extends BaseCrudService implements NomorIdentifikasiEksternalServiceInterface {
    protected function getRepositoryClass(): string {
        return NomorIdentifikasiEksternalRepositoryInterface::class;
    }
}