<?php

namespace App\Support\Interfaces\Services;

use App\Models\Task;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface TaskServiceInterface extends BaseCrudServiceInterface {

    public function create(array $data): ?Model;

    public function importData(UploadedFile $file): void;

    public function downloadFile(Task $task);
}
