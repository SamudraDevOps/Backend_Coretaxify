<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\UserRepositoryInterface;
use App\Support\Interfaces\Services\UserServiceInterface;

class UserService extends BaseCrudService implements UserServiceInterface {
    protected function getRepositoryClass(): string {
        return UserRepositoryInterface::class;
    }
}