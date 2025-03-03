<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfilSayaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'informasi_umum' => new InformasiUmumResource($this->informasi_umum),
            'alamat_wajib_pajak' => new AlamatWajibPajakResource($this->alamat_wajib_pajak),
            'data_ekonomi' => new DataEkonomiResource($this->data_ekonomi),
            'manajemen_kasus' => new ManajemenKasusResource($this->manajemen_kasus),
            'detail_bank' => new DetailBankResource($this->detail_bank),
            'nomor_identifikasi_eksternal' => new NomorIdentifikasiEksternalResource($this->nomor_identifikasi_eksternal),
            'penunjukkan_wajib_pajak_saya' => new PenunjukkanWajibPajakSayaResource($this->penunjukkan_wajib_pajak_saya),
            'jenis_pajak' => new JenisPajakResource($this->jenis_pajak),
            'objek_pajak_bumi_dan_bangunan' => new ObjekPajakBumiDanBangunanResource($this->objek_pajak_bumi_dan_bangunan),
            'detail_kontak' => new DetailKontakResource($this->detail_kontak),
            'kode_klu' => new KodeKluResource($this->kode_klu),
            'tempat_kegiatan_usaha' => new TempatKegiatanUsahaResource($this->tempat_kegiatan_usaha),
            'pihak_terkait' => new PihakTerkaitResource($this->pihak_terkait),
            'wakil_saya' => new WakilSayaResource($this->wakil_saya),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}