<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailBankResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'account_id' => new AccountResource($this->account),
            // 'assignment_users_id' => new AssignmentUserResource($this->assignment_users),
            'nama_bank' => $this->nama_bank,
            'nomor_rekening_bank' => $this->nomor_rekening_bank,
            'jenis_rekening_bank' => $this->jenis_rekening_bank,
            'keterangan' => $this->keterangan,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'is_rekening_bank_utama' => $this->is_rekening_bank_utama,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}