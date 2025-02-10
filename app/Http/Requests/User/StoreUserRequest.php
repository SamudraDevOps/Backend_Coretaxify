<?php

namespace App\Http\Requests\User;

use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
    public function rules(): array {
        $intent = $this->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_INSTRUCTOR->value:
                return [
                    'name' => 'required|string',
                    'email' => 'required|string',
                ];
            default:
                return [
                    'contract_id' => 'required|integer|exists:contracts,id',
                    'name' => 'required|string',
                    'email' => 'required|string',
                ];
        }
    }
}
