<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\ContractRepositoryInterface;
use App\Support\Interfaces\Services\ContractServiceInterface;

class ContractService extends BaseCrudService implements ContractServiceInterface {
    protected function getRepositoryClass(): string {
        return ContractRepositoryInterface::class;
    }
}