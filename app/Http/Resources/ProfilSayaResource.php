<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfilSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'informasi_umum' => InformasiUmumResource::make($this->informasi_umum),
            'alamat_wajib_pajak' => AlamatWajibPajakResource::make($this->alamat_wajib_pajak),
            'data_ekonomi' => DataEkonomiResource::make($this->data_ekonomi),
            'manajemen_kasus' => ManajemenKasusResource::make($this->manajemen_kasus),
            'detail_bank' => DetailBankResource::make($this->detail_bank),
            'nomor_identifikasi_eksternal' => NomorIdentifikasiEksternalResource::make($this->nomor_identifikasi_eksternal),
            'penunjukkan_wajib_pajak_saya' => PenunjukkanWajibPajakSayaResource::make($this->penunjukkan_wajib_pajak_saya),
            'jenis_pajak' => JenisPajakResource::make($this->jenis_pajak),
            'objek_pajak_bumi_dan_bangunan' => ObjekPajakBumiDanBangunanResource::make($this->objek_pajak_bumi_dan_bangunan),
            'detail_kontak' => DetailKontakResource::make($this->detail_kontak),
            'kode_klu' => KodeKluResource::make($this->kode_klu),
            'tempat_kegiatan_usaha' => TempatKegiatanUsahaResource::make($this->tempat_kegiatan_usaha),
            'pihak_terkait' => PihakTerkaitResource::make($this->pihak_terkait),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}