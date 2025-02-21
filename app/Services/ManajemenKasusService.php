<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\ManajemenKasusRepositoryInterface;
use App\Support\Interfaces\Services\ManajemenKasusServiceInterface;

class ManajemenKasusService extends BaseCrudService implements ManajemenKasusServiceInterface {
    protected function getRepositoryClass(): string {
        return ManajemenKasusRepositoryInterface::class;
    }
}