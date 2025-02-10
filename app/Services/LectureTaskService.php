<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use App\Models\LectureTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\Interfaces\Services\LectureTaskServiceInterface;
use App\Support\Interfaces\Repositories\LectureTaskRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\GroupUser;
use App\Models\TaskUser;

class LectureTaskService extends BaseCrudService implements LectureTaskServiceInterface {
    protected function getRepositoryClass(): string {
        return LectureTaskRepositoryInterface::class;
    }

    // public function create(array $data): ?Model {
    //     $data['task_code'] = LectureTask::generateTaskCode();
        
    //     $lectureTask = parent::create($data);
        
    //     return $lectureTask; 
    // }

    public function assignTask(array $data): ?Model {
        $lectureTask = LectureTask::where('task_code', $data['task_code'])->first();
        $lectureTaskId = $lectureTask->id;

        $groupId = $lectureTask->group->id;
        
        $groupUser = TaskUser::create([
            'user_id' => auth()->id(),
            'lecture_task_id' => $lectureTaskId,
            'group_id' => $groupId,
        ]);
        
        return $groupUser; 
    }
}