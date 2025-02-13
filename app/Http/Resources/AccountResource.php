<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'task' => TaskResource::make($this->task),
            'account_type' => AccountTypeResource::make($this->account_type),
            'nama' => $this->nama,
            'npwp' => $this->npwp,
            'kegiatan_utama' => $this->kegiatan_utama,
            'jenis_wajib_pajak' => $this->jenis_wajib_pajak,
            'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
            'status_npwp' => $this->status_npwp,
            'tanggal_terdaftar' => $this->tanggal_terdaftar,
            'tanggal_aktivasi' => $this->tanggal_aktivasi,
            'status_pengusaha_kena_pajak' => $this->status_pengusaha_kena_pajak,
            'tanggal_pengukuhan_pkp' => $this->tanggal_pengukuhan_pkp,
            'kantor_wilayah_direktorat_jenderal_pajak' => $this->kantor_wilayah_direktorat_jenderal_pajak,
            'kantor_pelayanan_pajak' => $this->kantor_pelayanan_pajak,
            'seksi_pengawasan' => $this->seksi_pengawasan,
            'tangal_pembaruan_profil_terakhir' => $this->tangal_pembaruan_profil_terakhir,
            'alamat_utama' => $this->alamat_utama,
            'nomor_handphone' => $this->nomor_handphone,
            'email' => $this->email,
            'kode_klasifikasi_lapangan_usaha' => $this->kode_klasifikasi_lapangan_usaha,
            'deskripsi_klasifikasi_lapangan_usaha' => $this->deskripsi_klasifikasi_lapangan_usaha,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
