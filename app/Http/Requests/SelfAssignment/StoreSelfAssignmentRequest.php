<?php

namespace App\Http\Requests\SelfAssignment;

use Illuminate\Foundation\Http\FormRequest;

class StoreSelfAssignmentRequest extends FormRequest {
    public function rules(): array {
        return [
            'task_id' => 'required|exists:tasks,id',
            'name' => 'required|string',
            'supporting_file' => 'sometimes|file',
        ];
    }
}
