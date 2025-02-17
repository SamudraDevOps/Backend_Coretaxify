<?php

namespace App\Http\Requests\Assignment;

use App\Support\Enums\IntentEnum;
use App\Support\Enums\AssignmentTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRequest extends FormRequest {
    public function rules(): array {

        $intent = $this->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_ASSIGNMENT->value:
                return [
                    'group_id' => 'required|exists:groups,id',
                    'name' => 'required|string',
                    'assignment_code' => 'required|string',
                    'start_period' => 'required|date',
                    'end_period' => 'required|date',
                ];
            case IntentEnum::API_USER_JOIN_ASSIGNMENT->value:
                return [
                    'assignment_code' => 'required|string',
                ];
            default:
                return [
                    'group_id' => 'required|exists:groups,id',
                    'name' => 'required|string',
                    'assignment_code' => 'required|string',
                    'start_period' => 'required|date',
                    'end_period' => 'required|date',
                ];
        }

    }
}
