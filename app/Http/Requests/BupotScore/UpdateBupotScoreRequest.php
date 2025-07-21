<?php

namespace App\Http\Requests\BupotScore;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Enums\BupotTypeEnum;

class UpdateBupotScoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'nullable|exists:sistems,id',
            'tipe_bupot' => 'nullable|in:' . implode(',', BupotTypeEnum::toArray()),
            'score' => 'nullable|integer|min:0|max:100',
        ];
    }
}
