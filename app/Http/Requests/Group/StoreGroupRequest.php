<?php

namespace App\Http\Requests\Group;

use App\Support\Enums\GroupStatusEnum;
use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest {
    public function rules(): array {
        $intent = $this->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_GROUP->value:
                return [
                    'name' => 'required|string',
                    'class_code' => 'required|string|unique:groups,class_code',
                    'status' => 'required|in:' . implode(',', GroupStatusEnum::toArray()),
                    'import_file' => 'nullable|mimes:xlsx,xls',
                ];
            case IntentEnum::API_USER_JOIN_GROUP->value:
                return [
                    'class_code' => 'required|string',
                ];
        }

        return [
            'name' => 'required|string',
            'status' => 'required|in:' . implode(',', GroupStatusEnum::toArray()),
        ];
    }
}
