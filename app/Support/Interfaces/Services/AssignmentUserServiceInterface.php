<?php

namespace App\Support\Interfaces\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface AssignmentUserServiceInterface extends BaseCrudServiceInterface {
    public function getAssignmentUserByUserId($userId, $perPage);

    public function getPic($assignmentUser);
}
