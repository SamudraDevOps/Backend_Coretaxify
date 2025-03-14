<?php

namespace App\Http\Requests\User;

use App\Support\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'contract_id' => 'sometimes|integer|exist:contract,id',
            'name' => 'sometimes|string',
            'email' => 'sometimes|string',
            'status' => 'sometimes|in:' . implode(',', UserStatusEnum::toArray()),
        ];
    }
}
