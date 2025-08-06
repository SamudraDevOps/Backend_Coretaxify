<?php

namespace App\Http\Resources;

use App\Support\Enums\JenisSptPpnEnum;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FakturCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $jenisSptPpn = $request->query('jenis_spt_ppn');

        switch($jenisSptPpn) {
            case JenisSptPpnEnum::B2->value:
                return $this->handleB2Format();
            case JenisSptPpnEnum::B3->value:
                return $this->handleB3Format();
            case JenisSptPpnEnum::C->value:
                return $this->handleCFormat();
            default:
                // Default behavior untuk jenis SPT PPN lainnya
                return $this->collection->map(function($faktur) use ($request) {
                    return (new FakturResource($faktur))->toArray($request);
                });
        }
    }

    private function handleB2Format()
    {
        $data = [];

        // Get faktur retur data from additional - pastikan menggunakan cara yang benar
        $fakturReturCollection = collect($this->additional['faktur_retur'] ?? []);

        foreach ($this->collection as $faktur) {
            // Data normal selalu masuk ke array 'data'
            $normalData = [
                'nama_pembeli' => $faktur->akun_pengirim->nama_akun,
                'npwp' => $faktur->akun_pengirim->npwp_akun,
                'faktur_pajak_nomor' => $faktur->nomor_faktur_pajak,
                'faktur_pajak_tanggal' => $faktur->tanggal_faktur_pajak,
                'dpp' => $faktur->dpp,
                'dpp_lain' => ($faktur->dpp_lain ?? 0),
                'ppn' => ($faktur->ppn ?? 0),
                'ppnbm' => ($faktur->ppnbm ?? 0),
            ];

            $data[] = $normalData;
        }

        // Process semua faktur retur yang ada
        foreach ($fakturReturCollection as $fakturRetur) {
            $returData = [
                'nama_pembeli' => $fakturRetur['akun_pengirim']['nama_akun'] ?? $fakturRetur->akun_pengirim->nama_akun,
                'npwp' => $fakturRetur['akun_pengirim']['npwp_akun'] ?? $fakturRetur->akun_pengirim->npwp_akun,
                'faktur_pajak_nomor' => $fakturRetur['nomor_retur'] ?? $fakturRetur->nomor_retur ?? ($fakturRetur['nomor_faktur_pajak'] ?? $fakturRetur->nomor_faktur_pajak),
                'faktur_pajak_tanggal' => $fakturRetur['tanggal_retur'] ?? $fakturRetur->tanggal_retur ?? ($fakturRetur['tanggal_faktur_pajak'] ?? $fakturRetur->tanggal_faktur_pajak),
                'dpp' => 0,
                'dpp_lain' => $fakturRetur['dpp_lain_retur'] ?? $fakturRetur->dpp_lain_retur ?? 0,
                'ppn' => $fakturRetur['ppn_retur'] ?? $fakturRetur->ppn_retur ?? 0,
                'ppnbm' => $fakturRetur['ppnbm_retur'] ?? $fakturRetur->ppnbm_retur ?? 0,
            ];

            $data[] = $returData;
        }

        return ['data' => $data];
    }

    private function handleB3Format()
    {
        $data = [];
        $dataRetur = [];

        foreach ($this->collection as $faktur) {
            // Data normal selalu masuk ke array 'data'
            $normalData = [
                'nama_pembeli' => $faktur->akun_pengirim->nama_akun,
                'npwp' => $faktur->akun_pengirim->npwp_akun,
                'faktur_pajak_nomor' => $faktur->nomor_faktur_pajak,
                'faktur_pajak_tanggal' => $faktur->tanggal_faktur_pajak,
                'dpp' => $faktur->dpp,
                'dpp_lain' => $faktur->dpp_lain,
                'ppn' => $faktur->ppn,
                'ppnbm' => $faktur->ppnbm,
            ];

            $data[] = $normalData;

            // Kalau ada retur, tambahkan ke array 'data_retur'
            if ($faktur->is_retur) {
                $returData = [
                    'nama_pembeli' => $faktur->akun_pengirim->nama_akun,
                    'npwp' => $faktur->akun_pengirim->npwp_akun,
                    'faktur_pajak_nomor' => $faktur->nomor_retur ?? $faktur->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $faktur->tanggal_retur ?? $faktur->tanggal_faktur_pajak,
                    'dpp' => 0,
                    'dpp_lain' => $faktur->dpp_lain_retur,
                    'ppn' => $faktur->ppn_retur,
                    'ppnbm' => $faktur->ppnbm_retur,
                ];

                $dataRetur[] = $returData;
            }
        }

        $result = ['data' => $data];

        if (!empty($dataRetur)) {
            $result['data_retur'] = $dataRetur;
        }

        return $result;
    }

    private function handleCFormat()
    {
        $data = [];
        $dataRetur = [];

        foreach ($this->collection as $faktur) {
            // Data normal selalu masuk ke array 'data'
            $normalData = [
                'nama_pembeli' => $faktur->akun_pengirim->nama_akun,
                'npwp' => $faktur->akun_pengirim->npwp_akun,
                'faktur_pajak_nomor' => $faktur->nomor_faktur_pajak,
                'faktur_pajak_tanggal' => $faktur->tanggal_faktur_pajak,
                'dpp' => $faktur->dpp,
                'dpp_lain' => $faktur->dpp_lain,
                'ppn' => $faktur->ppn,
                'ppnbm' => $faktur->ppnbm,
            ];

            $data[] = $normalData;

            // Kalau ada retur, tambahkan ke array 'data_retur'
            if ($faktur->is_retur) {
                $returData = [
                    'nama_pembeli' => $faktur->akun_pengirim->nama_akun,
                    'npwp' => $faktur->akun_pengirim->npwp_akun,
                    'faktur_pajak_nomor' => $faktur->nomor_retur ?? $faktur->nomor_faktur_pajak,
                    'faktur_pajak_tanggal' => $faktur->tanggal_retur ?? $faktur->tanggal_faktur_pajak,
                    'dpp' => 0,
                    'dpp_lain' => $faktur->dpp_lain_retur,
                    'ppn' => $faktur->ppn_retur,
                    'ppnbm' => $faktur->ppnbm_retur,
                ];

                $dataRetur[] = $returData;
            }
        }

        $result = ['data' => $data];

        if (!empty($dataRetur)) {
            $result['data_retur'] = $dataRetur;
        }

        return $result;
    }
}
