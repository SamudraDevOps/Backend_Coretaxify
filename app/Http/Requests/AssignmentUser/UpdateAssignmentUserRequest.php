<?php

namespace App\Http\Requests\AssignmentUser;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'user_id' => 'required|exist:user,id',
            'group_id' => 'required|exist:group,id',
            'score' => 'sometimes|integer',
        ];
    }
}
