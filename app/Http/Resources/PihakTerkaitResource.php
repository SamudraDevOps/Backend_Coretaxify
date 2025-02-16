<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PihakTerkaitResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'account_id' => new AccountResource($this->account),
            // 'assignment_users_id' => new AssignmentUserResource($this->assignment_users),
            'tipe_pihak_terkait' => $this->tipe_pihak_terkait,
            'is_pic' => $this->is_pic,
            'jenis_orang_terkait' => $this->jenis_orang_terkait,
            'npwp' => $this->npwp,
            'nomor_paspor' => $this->nomor_paspor,
            'kewarganegaraan' => $this->kewarganegaraan,
            'negara_asal' => $this->negara_asal,
            'email' => $this->email,
            'nomor_handphone' => $this->nomor_handphone,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}