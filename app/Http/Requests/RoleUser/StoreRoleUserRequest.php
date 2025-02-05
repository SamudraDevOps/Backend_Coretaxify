<?php

namespace App\Http\Requests\RoleUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id',
            'role_id' => 'required|exist:role,id',
        ];
    }
}