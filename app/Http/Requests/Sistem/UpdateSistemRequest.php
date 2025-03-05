<?php

namespace App\Http\Requests\Sistem;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Enums\IntentEnum;

class UpdateSistemRequest extends FormRequest {
    public function rules(): array {
        
        $intent = $this->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_UPDATE_KUASA_WAJIB->value:
                return [
                    // 'id' => 'required|exists:sistems,id',
                    // 'kuasa_wajib_pajak' => 'required|exists:sistems,id',
                ];
        }
        
        return [
            //
        ];
    }
}