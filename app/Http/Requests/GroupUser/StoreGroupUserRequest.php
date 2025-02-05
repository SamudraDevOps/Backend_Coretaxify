<?php

namespace App\Http\Requests\GroupUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id', 
            'group_id' => 'required|exist:group,id', 
        ];
    }
}