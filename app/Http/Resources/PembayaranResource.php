<?php

namespace App\Http\Resources;

use App\Support\Enums\JenisPajakEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranResource extends JsonResource {
    public function toArray($request): array {
        $checkDate = $this->masa_bulan;

        if ($checkDate){
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
            $masa_bulan = $this->masa_bulan;
            $masa_tahun = $this->masa_tahun;
            $bulanAngka = $bulanMap[$masa_bulan] ?? '00';
            $masa_pajak = $bulanAngka . $masa_tahun;
        } else {
            $masa_bulan = $this->masa_bulan;
            $masa_tahun = $this->masa_tahun;
            $masa_pajak = '0112'. $masa_tahun;
        }


        if($this->spt->jenis_pajak == JenisPajakEnum::PPH->value){
            if($this->spt->spt_pph->cl_bp1_5 !== null || $this->spt->spt_pph->cl_bp1_5 != 0){
                $bayar21 = $this->spt->spt_pph->cl_bp1_6;
            } else {
                $bayar21 = $this->spt->spt_pph->cl_bp1_5;
            }

            if($this->spt->spt_pph->cl_bp2_5 !== null || $this->spt->spt_pph->cl_bp2_5 != 0){
                $bayar26 = $this->spt->spt_pph->cl_bp2_6;
            } else {
                $bayar26= $this->spt->spt_pph->cl_bp2_5;
            }

            $data = [
                'id' => $this->id,
                'pic_id' => $this->pic_id,
                'npwp' => $this->sistem->npwp_akun,
                'nama' => $this->sistem->nama_akun,
                'alamat' => $this->sistem->alamat_utama_akun,
                'kode_billing' => $this->kode_billing,
                'kap_kjs_id' => '411121-100',
                'masa_bulan' => $masa_bulan,
                'masa_tahun' => $masa_tahun,
                'masa_pajak' => $masa_pajak,
                'keterangan' => $this->keterangan,
                'ntpn' => $this->ntpn,
                'is_paid' => $this->is_paid,
                'nilai' => $bayar21,
                'created_at' => $this->created_at->toDateTimeString(),
                'updated_at' => $this->updated_at->toDateTimeString(),
            ];

            $data2 = [
                'id' => $this->id,
                'masa_pajak' => $masa_pajak,
                'kap_kjs_id' => '411127-100',
                'nilai' => $bayar26,
                'created_at' => $this->created_at->toDateTimeString(),
                'updated_at' => $this->updated_at->toDateTimeString(),
            ];

            return [
                $data,
                $data2
            ];
        }

        return [
            'id' => $this->id,
            'pic_id' => $this->pic_id,
            'npwp' => $this->sistem->npwp_akun,
            'nama' => $this->sistem->nama_akun,
            'alamat' => $this->sistem->alamat_utama_akun,
            'kode_billing' => $this->kode_billing,
            'kap_kjs_id' => $this->kap_kjs->kode,
            'masa_bulan' => $masa_bulan,
            'masa_tahun' => $masa_tahun,
            'masa_pajak' => $masa_pajak,
            'keterangan' => $this->keterangan,
            'ntpn' => $this->ntpn,
            'is_paid' => $this->is_paid,
            'nilai' => $this->nilai,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

}
