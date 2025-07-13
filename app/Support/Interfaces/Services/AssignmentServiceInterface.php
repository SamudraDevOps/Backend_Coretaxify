<?php

namespace App\Support\Interfaces\Services;
use App\Models\Group;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface AssignmentServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data, ?Group $group = null): ?Model;

    public function createExam(array $data): ?Model;

    public function joinAssignment(array $data): ?Model;

    public function joinExam(array $data): ?Model;

    public function getAssignmentsByUserId($userId, $perPage);

    public function downloadFile(Assignment $assignment);
}
