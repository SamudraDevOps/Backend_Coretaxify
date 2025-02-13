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
use App\Models\TaskUser;

class AssignmentService extends BaseCrudService implements AssignmentServiceInterface {
    protected function getRepositoryClass(): string {
        return AssignmentRepositoryInterface::class;
    }

    // public function create(array $data): ?Model {
    //     $data['task_code'] = Assignment::generateTaskCode();

    //     $Assignment = parent::create($data);

    //     return $Assignment;
    // }

    public function assignTask(array $data): ?Model {
        $Assignment = Assignment::where('task_code', $data['task_code'])->first();
        $AssignmentId = $Assignment->id;

        $groupId = $Assignment->group->id;

        $groupUser = TaskUser::create([
            'user_id' => auth()->id(),
            'lecture_task_id' => $AssignmentId,
            'group_id' => $groupId,
        ]);

        return $groupUser;
    }
}
