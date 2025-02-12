<?php

namespace App\Http\Requests\AccountType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountTypeRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string',
            // Add your validation rules here
        ];
    }
}
