<?php

namespace App\Http\Resources;

use App\Support\Enums\JenisPajakEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class SptResource extends JsonResource {
    public function toArray($request): array {

        $bulanMap = [
                'Januari'   => '01',
                'Februari'  => '02',
                'Maret'     => '03',
                'April'     => '04',
                'Mei'       => '05',
                'Juni'      => '06',
                'Juli'      => '07',
                'Agustus'   => '08',
                'September' => '09',
                'Oktober'   => '10',
                'November'  => '11',
                'Desember'  => '12',
        ];

        $periode = $bulanMap[$this->masa_bulan] . $this->masa_tahun;

        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'model' => $this->model,
            'jenis_pajak' => $this->jenis_pajak,
            'is_can_pembetulan' => $this->is_can_pembetulan,
            'masa_bulan' => $this->masa_bulan,
            'masa_tahun' => $this->masa_tahun,
            'periode' => $periode,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
            'tanggal_dibuat' => $this->tanggal_dibuat,
            'nama_pengusaha' => $this->sistem->nama_akun,
            'alamat' => $this->sistem->alamat_utama_akun,
            'npwp' => $this->sistem->npwp_akun,
            'nomer_telpon' => $this->sistem->profil_saya->detail_kontak->nomor_telpon ?? null,
            'telepon_seluler' => $this->sistem->profil_saya->detail_kontak->nomor_handphone ?? null,
            'kota_badan' => $this->sistem->kota_badan,
            'nama_pic' => $this->pic->nama_akun,
            'npwp_pic' => $this->pic->npwp_akun,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];

        // Tambahkan detail SPT berdasarkan jenis_pajak
        switch ($this->jenis_pajak) {
            case JenisPajakEnum::PPN->value:
                $data['detail_spt'] = new SptPpnResource($this->whenLoaded('spt_ppn'));
                break;
            case JenisPajakEnum::PPH->value:
                $data['detail_spt'] = new SptPphResource($this->whenLoaded('spt_pph'));
                break;
            case JenisPajakEnum::PPH_UNIFIKASI->value:
                $data['detail_spt'] = new SptUnifikasiResource($this->whenLoaded('spt_unifikasi'));
                break;
            case JenisPajakEnum::PPH_BADAN->value:
                // $data['detail'] = new SptTahunanResource($this->whenLoaded('sptTahunan'));
                break;
        }

        return $data;
    }
}
