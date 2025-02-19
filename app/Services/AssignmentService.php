<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Support\Interfaces\Services\AssignmentServiceInterface;
use App\Support\Interfaces\Repositories\AssignmentRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class AssignmentService extends BaseCrudService implements AssignmentServiceInterface {
    protected function getRepositoryClass(): string {
        return AssignmentRepositoryInterface::class;
    }

    // public function create(array $data): ?Model {
    //     $data['assignment_code'] = Assignment::generateTaskCode();

    //     $Assignment = parent::create($data);

    //     return $Assignment;
    // }

    public function create(array $data): ?Model {
        $filename = $this->importData($data['supporting_file']);

        $assignment = Assignment::create([
            'group_id' => $data['group_id'],
            'name' => $data['name'],
            'assignment_code' => $data['assignment_code'],
            'start_period' => $data['start_period'],
            'end_period' => $data['end_period'],
            'supporting_file' => $filename,
        ]);

        AssignmentUser::create([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id,
        ]);

        return $assignment;
    }

    private function importData(UploadedFile $file) {
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('soal', $filename, 'public');

        return $filename;
    }

    public function joinAssignment(array $data): ?Model {
        $assignment = Assignment::where('assignment_code', $data['assignment_code'])->first();

        $assignmentUser = AssignmentUser::create([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id,
        ]);
        return $assignmentUser;
    }

    public function getAssignmentsByUserId($userId) {
        $repository = app($this->getRepositoryClass());

        return $repository->query()->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate();
        // return Assignment::where('user_id', $userId)
        // ->orWhereHas('users', function($query) use ($userId) {
        //     $query->where('user_id', $userId);
        // });
    }
}
