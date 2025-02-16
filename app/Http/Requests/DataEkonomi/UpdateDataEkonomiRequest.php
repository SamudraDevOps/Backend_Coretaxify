<?php

namespace App\Http\Requests\DataEkonomi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataEkonomiRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'merek_dagang' => 'nullable|string',
            'is_karyawan' => 'nullable|boolean',
            'jumlah_karyawan' => 'nullable|string',
            'metode_pembukuan' => 'nullable|string',
            'mata_uang_pembukuan' => 'nullable|string',
            'periode_pembukuan' => 'nullable|string',
            'omset_per_tahun' => 'nullable|string',
            'jumlah_peredaran_bruto' => 'nullable|string',
        ];
    }
}