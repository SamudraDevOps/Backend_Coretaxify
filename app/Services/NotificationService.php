<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\NotificationRepositoryInterface;
use App\Support\Interfaces\Services\NotificationServiceInterface;

class NotificationService extends BaseCrudService implements NotificationServiceInterface {
    protected function getRepositoryClass(): string {
        return NotificationRepositoryInterface::class;
    }
}