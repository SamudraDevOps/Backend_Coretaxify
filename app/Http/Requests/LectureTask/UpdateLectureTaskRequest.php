<?php

namespace App\Http\Requests\LectureTask;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'nullable|exist:user,id',
            'lecture_id' => 'nullable|exist:lecture,id',
            'task_id' => 'nullable|exist:task,id',
            'name' => 'nullable|string',
            'type' => 'nullable|string',
            'start_period' => 'nullable|date',
            'end_period' => 'nullable|date',
            'type' => 'nullable|string',
        ];
    }
}