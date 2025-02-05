<?php

namespace App\Http\Requests\LectureTask;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id',
            'lecture_id' => 'required|exist:lecture,id',
            'task_id' => 'required|exist:task,id',
            'name' => 'required|string',
            'type' => 'required|string',
            'start_period' => 'required|date',
            'end_period' => 'required|date',
            'type' => 'required|string',
        ];
    }
}