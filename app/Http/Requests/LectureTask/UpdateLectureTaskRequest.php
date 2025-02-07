<?php

namespace App\Http\Requests\LectureTask;

use App\Support\Enums\LectureTaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'group_id' => 'nullable|exists:groups,id',
            'task_id' => 'nullable|exists:tasks,id',
            'name' => 'nullable|string',
            'time' => 'nullable|string',
            'start_period' => 'nullable|date',
            'end_period' => 'nullable|date',
            'type' => 'nullable|in:' .
                implode(',', LectureTaskTypeEnum::toArray()),
        ];
    }
}