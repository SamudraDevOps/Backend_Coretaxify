<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\TempatKegiatanUsahaRepositoryInterface;
use App\Support\Interfaces\Services\TempatKegiatanUsahaServiceInterface;

class TempatKegiatanUsahaService extends BaseCrudService implements TempatKegiatanUsahaServiceInterface {
    protected function getRepositoryClass(): string {
        return TempatKegiatanUsahaRepositoryInterface::class;
    }
}