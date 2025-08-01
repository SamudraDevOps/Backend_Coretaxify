<?php

namespace App\Http\Resources;

use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class DataEkonomiResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        switch ($intent) {
            case IntentEnum::API_GET_SISTEM_DATA_EKONOMI_ORANG_PRIBADI->value:
                return [
                    'id' => $this->id,
                    'sumber_penghasilan' => $this->sumber_penghasilan,
                    'izin_usaha' => $this->izin_usaha,
                    'tanggal_izin_usaha' => $this->tanggal_izin_usaha,
                    'tempat_kerja' => $this->tempat_kerja,
                    'penghasilan_per_bulan' => $this->penghasilan_per_bulan,
                    'tanggal_mulai' => $this->tanggal_mulai,
                    'jumlah_karyawan' => $this->jumlah_karyawan,
                    'deskripsi_kegiatan' => $this->deskripsi_kegiatan,
                    'periode_pembukuan' => $this->periode_pembukuan,
                    'peredaran_bruto' => $this->peredaran_bruto,
                    'metode_pembukuan' => $this->metode_pembukuan,
                    'mata_uang_pembukuan' => $this->mata_uang_pembukuan,
                    // 'created_at' => $this->created_at->toDateTimeString(),
                    // 'updated_at' => $this->updated_at->toDateTimeString(),
                ];
            case IntentEnum::API_GET_SISTEM_DATA_EKONOMI_BADAN->value:
                return [
                    'id' => $this->id,
                    'sumber_penghasilan' => $this->sumber_penghasilan,
                    'izin_usaha' => $this->izin_usaha,
                    'tanggal_izin_usaha' => $this->tanggal_izin_usaha,
                    'tempat_kerja' => $this->penghasilan_per_bulan,
                    'penghasilan_per_bulan' => $this->penghasilan_per_bulan,
                    'tanggal_mulai' => $this->tanggal_mulai,
                    'jumlah_karyawan' => $this->jumlah_karyawan,
                    'deskripsi_kegiatan' => $this->deskripsi_kegiatan,
                    'periode_pembukuan' => $this->periode_pembukuan,
                    'peredaran_bruto' => $this->peredaran_bruto,
                    'metode_pembukuan' => $this->metode_pembukuan,
                    'mata_uang_pembukuan' => $this->mata_uang_pembukuan,
                    'merek_dagang' => $this->merek_dagang,
                    'omset_per_tahun' => $this->omset_per_tahun,
                    'jumlah_peredaran_bruto'=> $this->jumlah_peredaran_bruto,
                    // 'created_at' => $this->created_at->toDateTimeString(),
                    // 'updated_at' => $this->updated_at->toDateTimeString(),
                ];
        }
        return [
            'id' => $this->id,
            'sumber_penghasilan' => $this->sumber_penghasilan,
            'izin_usaha' => $this->izin_usaha,
            'tanggal_izin_usaha' => $this->tanggal_izin_usaha,
            'tempat_kerja' => $this->tempat_kerja,
            'penghasilan_per_bulan' => $this->penghasilan_per_bulan,
            'tanggal_mulai' => $this->tanggal_mulai,
            'jumlah_karyawan' => $this->jumlah_karyawan,
            'deskripsi_kegiatan' => $this->deskripsi_kegiatan,
            'periode_pembukuan' => $this->periode_pembukuan,
            'peredaran_bruto' => $this->peredaran_bruto,
            'metode_pembukuan' => $this->metode_pembukuan,
            'mata_uang_pembukuan' => $this->mata_uang_pembukuan,
            'merek_dagang' => $this->merek_dagang,
            'omset_per_tahun' => $this->omset_per_tahun,
            'jumlah_peredaran_bruto' => $this->jumlah_peredaran_bruto,
            // 'created_at' => $this->created_at->toDateTimeString(),
            // 'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
