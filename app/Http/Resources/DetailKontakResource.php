<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailKontakResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'account_id' => new AccountResource($this->account),
            // 'assignment_users_id' => new AssignmentUserResource($this->assignment_users),
            'jenis_kontak' => $this->jenis_kontak,
            'nomor_telpon' => $this->nomor_telpon,
            'nomor_handphone' => $this->nomor_handphone,
            'nomor_faksimile' => $this->nomor_faksimile,
            'alamat_email' => $this->alamat_email,
            'alamat_situs_wajib' => $this->alamat_situs_wajib,
            'keterangan' => $this->keterangan,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}