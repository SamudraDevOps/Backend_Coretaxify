<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'contract_id' => 'required|integer|exists:contracts,id',
            'name' => 'required|string',
            'email' => 'required|string',
        ];
    }
}
