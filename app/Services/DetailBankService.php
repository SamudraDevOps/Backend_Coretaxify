<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\DetailBankRepositoryInterface;
use App\Support\Interfaces\Services\DetailBankServiceInterface;

class DetailBankService extends BaseCrudService implements DetailBankServiceInterface {
    protected function getRepositoryClass(): string {
        return DetailBankRepositoryInterface::class;
    }
}