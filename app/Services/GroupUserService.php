<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\GroupUserRepositoryInterface;
use App\Support\Interfaces\Services\GroupUserServiceInterface;

class GroupUserService extends BaseCrudService implements GroupUserServiceInterface {
    protected function getRepositoryClass(): string {
        return GroupUserRepositoryInterface::class;
    }
}