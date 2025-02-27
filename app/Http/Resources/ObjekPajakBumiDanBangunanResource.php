<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObjekPajakBumiDanBangunanResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'nop' => $this->nop,
            'nama_objek_pajak' => $this->nama_objek_pajak,
            'sektor' => $this->sektor,
            'jenis' => $this->jenis,
            'tipe_bumi' => $this->tipe_bumi,
            'rincian' => $this->rincian,
            'status_kegiatan' => $this->status_kegiatan,
            'instansi_pemberi_izin' => $this->instansi_pemberi_izin,
            'luas_objek_pajak' => $this->luas_objek_pajak,
            'nomor_induk_berusaha' => $this->nomor_induk_berusaha,
            'tanggal_nomor_induk_berusaha' => $this->tanggal_nomor_induk_berusaha,
            'nomor_ijin_objek' => $this->nomor_ijin_objek,
            'tanggal_ijin_objek' => $this->tanggal_ijin_objek,
            'detail_alamat' => $this->detail_alamat,
            'provinsi' => $this->provinsi,
            'kota_kabupaten' => $this->kota_kabupaten,
            'kecamatan' => $this->kecamatan,
            'kelurahan_desa' => $this->kelurahan_desa,
            'kode_wilayah' => $this->kode_wilayah,
            'kode_pos' => $this->kode_pos,
            'data_geometri' => $this->data_geometri,
            'tanggal_pendaftaran' => $this->tanggal_pendaftaran,
            'tanggal_pencabutan_pendaftaran' => $this->tanggal_pencabutan_pendaftaran,
            'kode_kpp' => $this->kode_kpp,
            'seksi_pengawasan' => $this->seksi_pengawasan,                        
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}