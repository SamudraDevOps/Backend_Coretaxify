<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'nullable|string',
            'file_path' => 'nullable|string',
        ];
    }
}