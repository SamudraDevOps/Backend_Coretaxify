<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string',
            'file_path' => 'required|string',
        ];
    }
}