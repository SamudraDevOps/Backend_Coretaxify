<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\KapKjsRepositoryInterface;
use App\Support\Interfaces\Services\KapKjsServiceInterface;

class KapKjsService extends BaseCrudService implements KapKjsServiceInterface {
    protected function getRepositoryClass(): string {
        return KapKjsRepositoryInterface::class;
    }
}