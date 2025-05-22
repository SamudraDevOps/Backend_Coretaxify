<?php

namespace App\Http\Resources;

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



    return [
        'id' => $this->id,
        'pic_id' => $this->pic_id,
        'npwp' => $this->sistem->npwp_akun,
        'nama' => $this->sistem->nama_akun,
        'alamat' => $this->sistem->alamat_utama_akun,
        'kode_billing' => $this->kode_billing,
        'kapKjs' => $this->kapKjs,
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
