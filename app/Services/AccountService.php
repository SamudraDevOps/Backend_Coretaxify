<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\AccountRepositoryInterface;
use App\Support\Interfaces\Services\AccountServiceInterface;

class AccountService extends BaseCrudService implements AccountServiceInterface {
    protected function getRepositoryClass(): string {
        return AccountRepositoryInterface::class;
    }
}