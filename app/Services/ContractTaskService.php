<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\ContractTaskRepositoryInterface;
use App\Support\Interfaces\Services\ContractTaskServiceInterface;

class ContractTaskService extends BaseCrudService implements ContractTaskServiceInterface {
    protected function getRepositoryClass(): string {
        return ContractTaskRepositoryInterface::class;
    }
}