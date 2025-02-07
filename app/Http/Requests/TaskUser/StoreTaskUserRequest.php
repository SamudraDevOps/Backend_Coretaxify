<?php

namespace App\Http\Requests\TaskUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id',
            'group_id' => 'required|exist:group,id',
            'lecture_task_id' => 'required|exist:lecture_task,id',
            'score' => 'required|integer',
        ];
    }
}