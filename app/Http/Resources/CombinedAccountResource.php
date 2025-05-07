<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CombinedAccountResource extends JsonResource
{
    public function toArray($request)
    {
        //Cek apakah instance adalah Sistem
        if ($this->resource instanceof \App\Models\Sistem) {
            return [
                'id' => $this->id,
                'nama_akun' => $this->nama_akun,
                'npwp_akun' => $this->npwp_akun,
                'tipe_akun' => $this->tipe_akun,
                'email_akun' => $this->email_akun,
                'alamat_utama_akun' => $this->alamat_utama_akun,
                'negara_asal' => optional($this->profil_saya?->informasi_umum)->negara_asal,
                'is_akun_tambahan' => false,
            ];
        }

        // Jika instance adalah SistemTambahan
        if ($this->resource instanceof \App\Models\SistemTambahan) {
            return [
                'id' => $this->id,
                'nama_akun' => $this->nama_akun,
                'npwp_akun' => $this->npwp_akun,
                'tipe_akun' => $this->tipe_akun,
                'alamat_utama_akun' => $this->alamat_utama_akun,
                'email_akun' => $this->email_akun,
                'negara_asal' => $this->negara_asal,
                'is_akun_tambahan' => true,
            ];
        }

        // Default
        // return parent::toArray($request);
    }
}
