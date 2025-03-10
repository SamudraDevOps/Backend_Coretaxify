<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\PicRepositoryInterface;
use App\Support\Interfaces\Services\PicServiceInterface;

class PicService extends BaseCrudService implements PicServiceInterface {
    protected function getRepositoryClass(): string {
        return PicRepositoryInterface::class;
    }
}