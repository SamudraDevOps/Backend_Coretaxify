<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SistemTambahanResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'sistem_id' => $this->sistem_id,
            'nama_akun' => $this->nama_akun,
            'npwp_akun' => $this->npwp_akun,
            'tipe_akun' => $this->tipe_akun,
            'alamat_utama_akun' => $this->alamat_utama_akun,
            'email_akun' => $this->email_akun,
            'negara_asal' => $this->negara_asal,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
