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

    public function create(array $data, ?Group $group = null): ?Model {
        $filename = null;
        if(isset($data['supporting_file'])) {
            $filename = $this->importData($data['supporting_file']);
        }

        $data['user_id'] = auth()->id();

        if ($group) {
            $data['groups'] = [$group->id];
        }
        // $assignment = Assignment::create([
        //     'user_id' => $data['user_id'],
        //     'task_id' => $data['task_id'],
        //     'name' => $data['name'],
        //     'assignment_code' => $data['assignment_code'],
        //     'start_period' => $data['start_period'],
        //     'end_period' => $data['end_period'],
        //     'supporting_file' => $filename,
        // ]);

        // AssignmentUser::create([
        //     'user_id' => auth()->id(),
        //     'assignment_id' => $assignment->id,
        // ]);

        // Many to Many
        // if(isset($data['groups'])){
        //     $assignment->groups()->attach($data['groups']);
        // }

        // 1 Praktikum 1 Kelas
        if (isset($data['groups'])) {
            foreach ($data['groups'] as $group) {
                $data['assignment_code'] = Assignment::generateTaskCode();
                $assignment = Assignment::create([
                    'group_id' => $group,
                    'user_id' => $data['user_id'],
                    'task_id' => $data['task_id'],
                    'name' => $data['name'],
                    'assignment_code' => $data['assignment_code'],
                    'start_period' => $data['start_period'],
                    'end_period' => $data['end_period'],
                    'supporting_file' => $filename,
                ]);
            }
        } else {
            $data['assignment_code'] = Assignment::generateTaskCode();
            $assignment = Assignment::create([
                'user_id' => $data['user_id'],
                'task_id' => $data['task_id'],
                'name' => $data['name'],
                'assignment_code' => $data['assignment_code'],
                'start_period' => $data['start_period'],
                'end_period' => $data['end_period'],
                'supporting_file' => $filename,
            ]);
        }

        return $assignment;
    }

    public function update($keyOrModel, array $data): ?Model {
        // $model = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);
        // return parent::update($keyOrModel, $data);
        $filename = null;
        if(isset($data['supporting_file'])) {
            $filename = $this->importData($data['supporting_file']);
        }
        $assignment = parent::update($keyOrModel, $data);

        $assignment->update([
            'supporting_file' => $filename,
        ]);

        // if(isset($data['groups'])) {
        //     $assignment->groups()->sync($data['groups']);
        // }
        // $assignment->groups()->sync($data['groups']);

        return $assignment;
    }

    public function delete($keyOrModel): bool {
        $model = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        $model->users()->detach();
        // $model->groups()->detach();

        parent::delete($model);

        return true;
    }


    private function importData(UploadedFile $file) {
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('support-file', $filename, 'public');

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

    public function getAssignmentsByUserId($userId, $perPage = 15) {
        $repository = app($this->getRepositoryClass());
        $user = auth()->user();

        if($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
            return $repository->query()->whereHas('users', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate($perPage);
        } else if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('instruktur') || $user->hasRole('admin')) {
            return $repository->query()->whereHas('user', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->paginate($perPage);
        }
    }

    public function downloadFile(Assignment $assignment) {
        $filename = $assignment->supporting_file;
        $path = storage_path('app/public/support-file/' . $filename);
        return response()->download($path);
    }
}
