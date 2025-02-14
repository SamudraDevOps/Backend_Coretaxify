<?php

namespace App\Support\Interfaces\Services;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;

interface ExamServiceInterface extends BaseCrudServiceInterface {
    public function joinExam(array $data): ?Model;
}
