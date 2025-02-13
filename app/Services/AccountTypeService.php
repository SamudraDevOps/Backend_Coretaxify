<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\AccountTypeRepositoryInterface;
use App\Support\Interfaces\Services\AccountTypeServiceInterface;

class AccountTypeService extends BaseCrudService implements AccountTypeServiceInterface {
    protected function getRepositoryClass(): string {
        return AccountTypeRepositoryInterface::class;
    }
}