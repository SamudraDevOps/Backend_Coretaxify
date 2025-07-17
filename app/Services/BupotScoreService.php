<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\BupotScoreRepositoryInterface;
use App\Support\Interfaces\Services\BupotScoreServiceInterface;

class BupotScoreService extends BaseCrudService implements BupotScoreServiceInterface {
    protected function getRepositoryClass(): string {
        return BupotScoreRepositoryInterface::class;
    }
}