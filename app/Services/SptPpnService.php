<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SptPpnRepositoryInterface;
use App\Support\Interfaces\Services\SptPpnServiceInterface;

class SptPpnService extends BaseCrudService implements SptPpnServiceInterface {
    protected function getRepositoryClass(): string {
        return SptPpnRepositoryInterface::class;
    }
}