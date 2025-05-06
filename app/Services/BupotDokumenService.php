<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotDokumenRepositoryInterface;
use App\Support\Interfaces\Services\BupotDokumenServiceInterface;

class BupotDokumenService extends BaseCrudService implements BupotDokumenServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotDokumenRepositoryInterface::class;
    }
}