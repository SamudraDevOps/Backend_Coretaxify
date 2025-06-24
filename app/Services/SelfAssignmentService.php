<?php

namespace App\Services;

use App\Models\SelfAssignment;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Support\Interfaces\Services\SelfAssignmentServiceInterface;
use App\Support\Interfaces\Repositories\SelfAssignmentRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SelfAssignmentService extends BaseCrudService implements SelfAssignmentServiceInterface
{
    protected function getRepositoryClass(): string
    {
        return SelfAssignmentRepositoryInterface::class;
    }

    public function create(array $data): ?Model
    {
        $filename = null;
        if (isset($data['supporting_file'])) {
            $filename = $this->importData($data['supporting_file']);
        }

        $data['user_id'] = auth()->id();

        $selfAssignment = parent::create($data);

        return $selfAssignment;
    }

    public function update($keyOrModel, array $data): ?Model
    {
        $selfAssignment = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);


        // $model = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);
        // return parent::update($keyOrModel, $data);
        $selfAssignment = parent::update($keyOrModel, $data);

        if (isset($data['supporting_file'])) {
            Storage::disk('public')->delete('support-file.' . $selfAssignment->file_path);
            $filename = $this->importData($data['supporting_file']);
            $selfAssignment->update([
                'supporting_file' => $filename,
            ]);
        }


        // if(isset($data['groups'])) {
        //     $selfAssignment->groups()->sync($data['groups']);
        // }
        // $selfAssignment->groups()->sync($data['groups']);

        return $selfAssignment;
    }

    public function delete($keyOrModel): bool
    {
        $model = $keyOrModel instanceof Model ? $keyOrModel : $this->find($keyOrModel);

        // $model->user()->detach();
        // $model->groups()->detach();

        parent::delete($model);

        return true;
    }


    private function importData(UploadedFile $file)
    {
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->storeAs('support-file', $filename, 'public');

        return $filename;
    }

    public function getSelfAssignmentsByUserId($userId, $perPage = 15)
    {
        $repository = app($this->getRepositoryClass());
        $user = auth()->user();

        return $repository->query()->whereHas('user', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate($perPage);

    }

    public function downloadFile(SelfAssignment $selfAssignment)
    {
        $filename = $selfAssignment->supporting_file;
        $path = storage_path('app/public/support-file/' . $filename);
        return response()->download($path);
    }
}
