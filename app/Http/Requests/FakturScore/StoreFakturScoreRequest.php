<?php

namespace App\Http\Requests\FakturScore;

use App\Support\Enums\FakturTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreFakturScoreRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'required|exists:sistems,id',
            'tipe_faktur' => 'required|in:' . implode(',', FakturTypeEnum::toArray()),
            'score' => 'required|integer|min:0|max:100',
        ];
    }
}
