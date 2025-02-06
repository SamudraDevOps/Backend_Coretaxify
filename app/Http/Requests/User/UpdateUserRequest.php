<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'contract_id' => 'nullable|integer|exist:contract,id',
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'password' => 'nullable|string',
            'image_path' => 'nullable|string',
            'unique_id' => 'nullable|string',
            'registration_code' => 'nullable|string',
            'lecture_id' => 'nullable|integer',
        ];
    }
}