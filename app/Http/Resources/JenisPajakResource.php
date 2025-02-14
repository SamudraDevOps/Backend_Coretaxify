<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JenisPajakResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'account_id' => new AccountResource($this->account),
            // 'assignment_users_id' => new AssignmentUserResource($this->assignment_users),
            'jenis_pajak' => $this->jenis_pajak,
            'tanggal_permohonan' => $this->tanggal_permohonan,
            'tanggal_mulai_transaksi' => $this->tanggal_mulai_transaksi,
            'tanggal_pendaftaran' => $this->tanggal_pendaftaran,
            'tanggal_pencabutan_pendaftaran' => $this->tanggal_pencabutan_pendaftaran,
            'nomor_kasus' => $this->nomor_kasus,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}