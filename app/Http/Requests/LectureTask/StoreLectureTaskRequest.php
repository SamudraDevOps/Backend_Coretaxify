<?php

namespace App\Http\Requests\LectureTask;

use App\Support\Enums\LectureTaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreLectureTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'group_id' => 'required|exists:groups,id',
            'task_id' => 'required|exists:tasks,id',
            'name' => 'required|string',
            'time' => 'required|string',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'type' => 'required|in:' .
                implode(',', LectureTaskTypeEnum::toArray()),
        ];
    }
}