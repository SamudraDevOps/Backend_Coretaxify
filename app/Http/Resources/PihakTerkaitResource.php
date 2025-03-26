<?php

namespace App\Http\Resources;

use App\Support\Enums\IntentEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class PihakTerkaitResource extends JsonResource {
    public function toArray($request): array {
        $intent = $request->get('intent');
        switch ($intent) {
            case IntentEnum::API_GET_KUASA_WAJIB_SAYA->value:
                return [
                    'id' => $this->id,
                    'npwp' => $this->npwp,
                    'nama_pengurus' => $this->nama_pengurus,
                    'id_penunjukkan_perwakilan' => $this->id_penunjukkan_perwakilan,
                ];
        }

        return [
            'id' => $this->id,
            'npwp' => $this->npwp,
            'nama_pengurus' => $this->nama_pengurus,
            'jenis_orang_terkait' => $this->jenis_orang_terkait,
            'kategori_wajib_pajak' => $this->kategori_wajib_pajak,
            'kewarganegaraan' => $this->kewarganegaraan,
            'negara_asal' => $this->negara_asal,
            'sub_orang_terkait' => $this->sub_orang_terkait,
            'id_penunjukkan_perwakilan' => $this->id_penunjukkan_perwakilan,
            'keterangan' => $this->keterangan,
            'is_orang_terkait' => $this->is_orang_terkait,
            'is_penanggung_jawab' => $this->is_penanggung_jawab,
            'tanggal_mulai'  => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'adalah_data_eksternal' => $this->adalah_data_eksternal,
            'nomor_paspor' => $this->nomor_paspor,
            'presentasi_pemgegang_saham' => $this->presentasi_pemgegang_saham,
            'klasifikasi_saham' => $this->klasifikasi_saham,
            'jenis_wajib_pajak_terkait' => $this->jenis_wajib_pajak_terkait,
            'kewarganegaraan_pemegang_saham' => $this->kewarganegaraan_pemegang_saham,
            'kriteria_pemilik_manfaat'=> $this->kriteria_pemilik_manfaat,
            'tanggal_selesai' => $this->tanggal_selesai,

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
