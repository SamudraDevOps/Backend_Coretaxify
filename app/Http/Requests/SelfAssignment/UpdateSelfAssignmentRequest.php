<?php

namespace App\Http\Requests\SelfAssignment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSelfAssignmentRequest extends FormRequest {
    public function rules(): array {
        return [
            'task_id' => 'nullable|exists:tasks,id',
            'name' => 'nullable|string',
            'supporting_file' => 'nullable|file',
        ];
    }
}
