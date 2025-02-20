<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TempatKegiatanUsahaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
 
            'nitku' => $this->nitku,
            'jenis_tku' => $this->jenis_tku,
            'nama_tku' => $this->nama_tku,
            'deskripsi_tku' => $this->deskripsi_tku,
            'nama_klu' => $this->nama_klu,
            'deskripsi_klu' => $this->deskripsi_klu,
            'tambah_pic_tku_id' => $this->tambah_pic_tku_id,
            'jenis_alamat' => $this->jenis_alamat,
            'detail_alamat' => $this->detail_alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'provinsi' => $this->provinsi,
            'kota_kabupaten' => $this->kota_kabupaten,
            'kecamatan' => $this->kecamatan,
            'kelurahan_desa' => $this->kelurahan_desa,
            'kode_pos' => $this->kode_pos,
            'data_geometri' => $this->data_geometri,
            'seksi_pengawasan' => $this->seksi_pengawasan,
            'is_lokasi_yang_disewa' => $this->is_lokasi_yang_disewa,
            'tanggal_dimulai' => $this->tanggal_dimulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'is_toko_retail' => $this->is_toko_retail,
            'is_kawasan_bebas' => $this->is_kawasan_bebas,
            'is_kawasan_ekonomi_khusus' => $this->is_kawasan_ekonomi_khusus,
            'is_tempat_penimbunan_berikat' => $this->is_tempat_penimbunan_berikat,
            'nomor_surat_keputusan' => $this->nomor_surat_keputusan,
            'decree_number_data_valid_from' => $this->decree_number_data_valid_from,
            'decree_number_data_valid_to' => $this->decree_number_data_valid_to,
            'kode_kpp' => $this->kode_kpp,
            'is_alamat_utama_pkp' => $this->is_alamat_utama_pkp,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}