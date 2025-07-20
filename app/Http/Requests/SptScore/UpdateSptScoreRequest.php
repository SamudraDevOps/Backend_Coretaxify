<?php

namespace App\Http\Requests\SptScore;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSptScoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'nullable|exists:sistems,id',
            'score' => 'nullable|integer|min:0|max:100',
        ];
    }
}
