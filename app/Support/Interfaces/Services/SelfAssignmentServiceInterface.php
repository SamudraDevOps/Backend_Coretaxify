<?php

namespace App\Support\Interfaces\Services;
use App\Models\SelfAssignment;
use Illuminate\Database\Eloquent\Model;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface SelfAssignmentServiceInterface extends BaseCrudServiceInterface {
    public function create(array $data): ?Model;

    public function getSelfAssignmentsByUserId($userId, $perPage);

    public function downloadFile(SelfAssignment $selfAssignment);
}
