<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\FakturScoreRepositoryInterface;
use App\Support\Interfaces\Services\FakturScoreServiceInterface;

class FakturScoreService extends BaseCrudService implements FakturScoreServiceInterface {
    protected function getRepositoryClass(): string {
        return FakturScoreRepositoryInterface::class;
    }
}