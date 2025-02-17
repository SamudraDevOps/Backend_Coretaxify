<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use App\Models\Assignment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\Interfaces\Services\AssignmentServiceInterface;
use App\Support\Interfaces\Repositories\AssignmentRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\GroupUser;
use App\Models\AssignmentUser;

class AssignmentService extends BaseCrudService implements AssignmentServiceInterface {
    protected function getRepositoryClass(): string {
        return AssignmentRepositoryInterface::class;
    }

    // public function create(array $data): ?Model {
    //     $data['assignment_code'] = Assignment::generateTaskCode();

    //     $Assignment = parent::create($data);

    //     return $Assignment;
    // }

    public function joinAssignment(array $data): ?Model {
        $Assignment = Assignment::where('assignment_code', $data['assignment_code'])->first();
        $AssignmentId = $Assignment->id;

        $groupId = $Assignment->group->id;

        $groupUser = AssignmentUser::create([
            'user_id' => auth()->id(),
            'group_id' => $groupId,
        ]);

        return $groupUser;
    }
}
