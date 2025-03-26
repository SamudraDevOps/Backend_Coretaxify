<?php

namespace App\Support\Interfaces\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SistemRepositoryInterface extends BaseRepositoryInterface {
    public function getByAssignmentUser(int $assignmentUserId): Collection;

    public function getFirstByAssignmentUser(int $assignmentUserId): ?Model;

    public function getByAssignmentUserAndId(int $assignmentUserId, int $sistemId): ?Model;

    public function getOrangPribadiByAssignmentUser(int $assignmentUserId): Collection;
}