<?php

namespace App\Http\Requests\ManajemenKasus;

use Illuminate\Foundation\Http\FormRequest;

class StoreManajemenKasusRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'kanal' => 'nullable|string|max:255',
            'tanggal_permohonan' => 'nullable|date',
        ];
    }
}