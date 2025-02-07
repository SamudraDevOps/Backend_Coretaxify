<?php

namespace App\Http\Requests\LectureTask;

use App\Support\Enums\LectureTaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreLectureTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id',
            'task_id' => 'required|exist:task,id',
            'name' => 'required|string',
            'type' => 'required|string',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'type' => 'required|in:' .
                implode(',', LectureTaskTypeEnum::toArray()),
        ];
    }
}