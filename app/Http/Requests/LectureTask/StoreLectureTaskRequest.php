<?php

namespace App\Http\Requests\LectureTask;

use App\Support\Enums\IntentEnum;
use App\Support\Enums\LectureTaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreLectureTaskRequest extends FormRequest {
    public function rules(): array {
        
        $intent = $this->get('intent');
        
        switch ($intent) {
            case IntentEnum::API_USER_CREATE_LECTURE_TASK->value:
                return [
                    'group_id' => 'required|exists:groups,id',
                    'task_id' => 'required|exists:tasks,id',
                    'name' => 'required|string',
                    'time' => 'required|string',
                    'task_code' => 'required|string',
                    'start_period' => 'required|date',
                    'end_period' => 'required|date',
                    'type' => 'required|in:' .
                        implode(',', LectureTaskTypeEnum::toArray()),
                ];
            case IntentEnum::API_USER_ASSIGN_TASK->value:
                return [
                    'task_code' => 'required|string',
                ];   
        }        
    }
}