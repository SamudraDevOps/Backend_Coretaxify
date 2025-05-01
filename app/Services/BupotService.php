<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotRepositoryInterface;
use App\Support\Interfaces\Services\BupotServiceInterface;

class BupotService extends BaseCrudService implements BupotServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotRepositoryInterface::class;
    }
}