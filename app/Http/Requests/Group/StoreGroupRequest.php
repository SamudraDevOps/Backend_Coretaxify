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
                    'qty_student' => 'required|integer',
                    'start_period' => 'required|date',
                    'end_period' => 'required|date|after:start_time',
                    'spt' => 'required|integer',
                    'bupot' => 'required|integer',
                    'faktur' => 'required|integer',
                    'status' => 'required|in:' .
                        implode(',', GroupStatusEnum::toArray()),
                ];
            case IntentEnum::API_USER_JOIN_GROUP->value:
                return [
                    'class_code' => 'required|string',
                ];
        }
        
        return [
            'name' => 'required|string',
            'qty_student' => 'required|integer',
            'start_period' => 'required|date',
            'end_period' => 'required|date|after:start_time',
            'spt' => 'required|integer',
            'bupot' => 'required|integer',
            'faktur' => 'required|integer',
            'status' => 'required|in:' .
                implode(',', GroupStatusEnum::toArray()),
        ];
    }
}