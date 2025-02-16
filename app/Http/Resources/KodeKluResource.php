<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KodeKluResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'account_id' => new AccountResource($this->account),
            // 'assignment_users_id' => new AssignmentUserResource($this->assignment_users),
            'kode_nama' => $this->kode_nama,
            'deskripsi_klu' => $this->deskripsi_klu,
            'deskripsi_tku' => $this->deskripsi_tku,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}