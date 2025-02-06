<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'contract_id' => 'integer|exist:contract,id',
            'name' => 'string',
            'email' => 'string',
        ];
    }
}
