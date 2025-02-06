<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\RoleUserRepositoryInterface;
use App\Support\Interfaces\Services\RoleUserServiceInterface;

class RoleUserService extends BaseCrudService implements RoleUserServiceInterface {
    protected function getRepositoryClass(): string {
        return RoleUserRepositoryInterface::class;
    }
}