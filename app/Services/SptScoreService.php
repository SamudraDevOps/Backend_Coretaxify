<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SptScoreRepositoryInterface;
use App\Support\Interfaces\Services\SptScoreServiceInterface;

class SptScoreService extends BaseCrudService implements SptScoreServiceInterface {
    protected function getRepositoryClass(): string {
        return SptScoreRepositoryInterface::class;
    }
}