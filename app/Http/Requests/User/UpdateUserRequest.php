<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'contract_id' => 'nullable|integer|exist:contract,id',
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'image_path' => 'required|string',
            'unique_id' => 'required|string',
            'registration_code' => 'required|string',
            'lecture_id' => 'required|integer',
        ];
    }
}