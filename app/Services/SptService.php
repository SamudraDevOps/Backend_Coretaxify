<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Pic;
use App\Models\Spt;
use App\Models\Bupot;
use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\SptPph;
use App\Models\SptPpn;
use App\Models\Assignment;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use App\Models\SptUnifikasi;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\SptResource;
use App\Support\Enums\SptModelEnum;
use App\Support\Enums\BupotTypeEnum;
use App\Support\Enums\SptStatusEnum;
use App\Support\Helpers\MonthHelper;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BupotResource;
use App\Support\Enums\JenisPajakEnum;
use App\Http\Resources\FakturResource;
use App\Support\Enums\JenisSptPphEnum;
use App\Support\Enums\JenisSptPpnEnum;
use App\Support\Enums\FakturStatusEnum;
use Illuminate\Database\Eloquent\Model;
use App\Support\Enums\JenisSptPphUnifikasiEnum;
use App\Support\Interfaces\Services\SptServiceInterface;
use App\Support\Interfaces\Repositories\SptRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;

class SptService extends BaseCrudService implements SptServiceInterface {
    protected function getRepositoryClass(): string {
        return SptRepositoryInterface::class;
    }

    public function update ($spt, $request):Model{
        $intent = $request['intent'];
        $sistem_id = $request['badan_id'];
        $ntpn = Str::random(16);
        // $fields_spt_ppn = [
        //     'cl_1a1_dpp', 'cl_1a5_dpp', 'cl_1a9_dpp', 'cl_1a5_ppn', 'cl_1a9_ppn','cl_1a5_ppnbm','cl_1a9_ppnbm','cl_2e_ppn','cl_2h_dpp','cl_2i_dpp','cl_3b_ppn','cl_3d_ppn','cl_3f_ppn','cl_6b_ppnbm','cl_6d_ppnbm','cl_7a_dpp','cl_7b_dpp','cl_7a_ppn','cl_7b_ppn','cl_7a_ppnbm','cl_7b_ppnbm','cl_7a_dpp_lain','cl_7b_dpp_lain','cl_8a_dpp','cl_8b_dpp','cl_8a_ppn','cl_8b_ppn','cl_8a_ppnbm','cl_8b_ppnbm','cl_8a_dpp_lain','cl_8b_dpp_lain','cl_8d_diminta_pengembalian', 'cl_3h_diminta','cl_3h_nomor_rekening','cl_3h_nama_bank','cl_3h_nama_pemilik_rekening',
        // ];

        $fields_spt_ppn = [
            'cl_1a9_dpp','cl_1a9_dpp_lain','cl_1a9_ppn','cl_1a9_ppnbm','cl_2e_ppn','cl_2f_ppn','cl_2i_dpp','cl_3b_ppn','cl_3d_ppn','cl_3f_ppn','cl_2i_dpp','cl_8d_diminta_pengembalian', 'cl_3h_diminta','cl_3h_nomor_rekening','cl_3h_nama_bank','cl_3h_nama_pemilik_rekening','cl_4_ppn_terutang_dpp','cl_5_ppn_wajib'
        ];

        $fields_spt_pph = [
            'cl_bp1_2', 'cl_bp1_3', 'cl_bp1_4', 'cl_bp1_6','cl_bp2_2', 'cl_bp2_3', 'cl_bp2_4', 'cl_bp2_6'
        ];

        $requestData = is_array($request) ? $request : $request->all();

        $masaAktif = Carbon::now()->addWeek();

        if ($spt->jenis_pajak == JenisPajakEnum::PPN->value) {
            $spt_ppn = SptPpn::where('spt_id', $spt->id)->first();

            if (!$spt_ppn) {
                throw new \Exception('SPT PPN tidak ditemukan untuk SPT ID: ' . $spt->id, 404);
            }

            foreach ($fields_spt_ppn as $field) {
                if (array_key_exists($field, $requestData)) {
                    // Handle null values - set to 0 if null
                    $spt_ppn->$field = $requestData[$field] ?? 0;
                }
            }

            // Fill remaining data, ensuring null values become 0 for numeric fields
            $filteredData = [];
            foreach ($requestData as $key => $value) {
                // Set null values to 0 for numeric fields, keep original for text fields
                if (in_array($key, ['cl_3h_nomor_rekening', 'cl_3h_nama_bank', 'cl_3h_nama_pemilik_rekening'])) {
                    $filteredData[$key] = $value; // Keep original for text fields
                } else {
                    $filteredData[$key] = $value ?? 0; // Set to 0 for numeric fields
                }
            }

            $spt_ppn->fill($filteredData);
            $spt_ppn->save();

        } elseif ($spt->jenis_pajak == JenisPajakEnum::PPH->value) {
            // Fix: Use SptPph instead of SptPpn
            $spt_pph = SptPph::where('spt_id', $spt->id)->first();

            if (!$spt_pph) {
                throw new \Exception('SPT PPH tidak ditemukan untuk SPT ID: ' . $spt->id, 404);
            }

            foreach ($fields_spt_pph as $field) {
                if (array_key_exists($field, $requestData)) {
                    // Handle null values - set to 0 if null
                    $spt_pph->$field = $requestData[$field] ?? 0;
                }
            }

            // Fill remaining data, ensuring null values become 0
            $filteredData = [];
            foreach ($requestData as $key => $value) {
                $filteredData[$key] = $value ?? 0;
            }

            $spt_pph->fill($filteredData);
            $spt_pph->save();
        }

        switch ($intent) {
            case IntentEnum::API_UPDATE_SPT_PPN_BAYAR_KODE_BILLING->value:
                $spt->status = SptStatusEnum::MENUNGGU_PEMBAYARAN->value;
                $spt->is_can_pembetulan = true;
                $spt->save();

                $spt_ppn = SptPpn::where('spt_id', $spt->id)->first();

                $randomNumber = mt_rand(100000000000000, 999999999999999);

                if ($spt_ppn->cl_3f_ppn && $spt_ppn->cl_3f_ppn > 0){
                    $bayar = $spt_ppn->cl_3g_ppn;
                }else {
                    $bayar = $spt_ppn->cl_3e_ppn;
                }

                $dataPembayaran['nilai'] = $bayar;
                $dataPembayaran['masa_bulan'] = $spt->masa_bulan;
                $dataPembayaran['masa_tahun'] = $spt->masa_tahun;
                $dataPembayaran['badan_id'] = $request['badan_id'];
                $dataPembayaran['pic_id'] = $request['pic_id'];
                $dataPembayaran['kode_billing'] = $randomNumber;
                $dataPembayaran['kap_kjs_id'] = 49;
                $dataPembayaran['ntpn'] = $ntpn;
                $dataPembayaran['masa_aktif'] = $masaAktif;
                $dataPembayaran['spt_id'] = $spt->id;

                Pembayaran::create($dataPembayaran);
                break;
            case IntentEnum::API_UPDATE_SPT_PPN_BAYAR_DEPOSIT->value:
                $sistem = Sistem::find($sistem_id);

                $spt_ppn = SptPpn::where('spt_id', $spt->id)->first();

                if ($spt_ppn->cl_3f_ppn){
                    $bayar = $spt_ppn->cl_3g_ppn;
                }else {
                    $bayar = $spt_ppn->cl_3e_ppn;
                }

                $saldo = (int) $sistem->saldo;
                $hasil = $saldo - $bayar;

                if ($hasil < 0) {
                    throw new \Exception('Saldo tidak mencukupi', 101);
                } else {
                    $dataPembayaran['nilai'] = $bayar;
                    $dataPembayaran['ntpn'] = $ntpn;
                    $dataPembayaran['masa_bulan'] = $spt->masa_bulan;
                    $dataPembayaran['masa_tahun'] = $spt->masa_tahun;
                    $dataPembayaran['badan_id'] = $request['badan_id'];
                    $dataPembayaran['pic_id'] = $request['pic_id'];
                    $dataPembayaran['kap_kjs_id'] = 49;
                    $dataPembayaran['is_paid'] = true;
                    $dataPembayaran['masa_aktif'] = $masaAktif;
                    $dataPembayaran['spt_id'] = $spt->id;

                    $sistem->saldo = $hasil;
                    $sistem->save();

                    $spt->status = SptStatusEnum::DILAPORKAN->value;
                    $spt->is_can_pembetulan = true;
                    $spt->save();

                    $pembayaran = Pembayaran::create($dataPembayaran);
                    return $pembayaran;
                }
            case IntentEnum::API_UPDATE_SPT_PPH_BAYAR_KODE_BILLING->value:
                $spt->status = SptStatusEnum::MENUNGGU_PEMBAYARAN->value;
                $spt->is_can_pembetulan = true;
                $spt->save();
                $randomNumber = mt_rand(100000000000000, 999999999999999);

                $spt_pph = SptPph::where('spt_id', $spt->id)->first();

                if($spt_pph->cl_bp1_5 !== null || $spt_pph->cl_bp1_5 != 0){
                    $bayar21 = $spt_pph->cl_bp1_6 ?? 0;
                } else {
                    $bayar21 = $spt_pph->cl_bp1_5 ?? 0;
                }

                if($spt_pph->cl_bp2_5 !== null || $spt_pph->cl_bp2_5 != 0){
                    $bayar26 = $spt_pph->cl_bp2_6 ?? 0;
                } else {
                    $bayar26= $spt_pph->cl_bp2_5 ?? 0;
                }

                $bayar = ($bayar21 + ($spt_pph->cl_bp1_7 ?? 0)) + ($bayar26 + ($spt_pph->cl_bp2_7 ?? 0));


                $dataPembayaran = [
                    'nilai' => $bayar,
                    'masa_bulan' => $spt->masa_bulan,
                    'masa_tahun' => $spt->masa_tahun,
                    'badan_id' => $request['badan_id'],
                    'pic_id' => $request['pic_id'],
                    'kode_billing' => $randomNumber,
                    // 'kap_kjs_id' => $data['kap_kjs_id'],
                    'ntpn' => $ntpn,
                    'masa_aktif' => $masaAktif,
                    'spt_id' => $spt->id,
                ];

                Pembayaran::create($dataPembayaran);
                break;
            case IntentEnum::API_UPDATE_SPT_PPH_BAYAR_DEPOSIT->value:
                $sistem = Sistem::find($sistem_id);

                if($spt_pph->cl_bp1_5 !== null || $spt_pph->cl_bp1_5 != 0){
                    $bayar21 = $spt_pph->cl_bp1_6 ?? 0;
                } else {
                    $bayar21 = $spt_pph->cl_bp1_5 ?? 0;
                }

                if($spt_pph->cl_bp2_5 !== null || $spt_pph->cl_bp2_5 != 0){
                    $bayar26 = $spt_pph->cl_bp2_6 ?? 0;
                } else {
                    $bayar26= $spt_pph->cl_bp2_5 ?? 0;
                }

                $bayar = ($bayar21 + ($spt_pph->cl_bp1_7 ?? 0)) + ($bayar26 + ($spt_pph->cl_bp2_7 ?? 0));

                $saldo = (int) $sistem->saldo;
                $hasil = $saldo - $bayar;

                if ($hasil < 0) {
                    throw new \Exception('Saldo tidak mencukupi', 101);
                } else {
                    $dataPembayaran['nilai'] = $bayar;
                    $dataPembayaran['ntpn'] = $ntpn;
                    $dataPembayaran['masa_bulan'] = $spt->masa_bulan;
                    $dataPembayaran['masa_tahun'] = $spt->masa_tahun;
                    $dataPembayaran['badan_id'] = $request['badan_id'];
                    $dataPembayaran['pic_id'] = $request['pic_id'];
                    $dataPembayaran['ntpn'] = $ntpn;
                    // $dataPembayaran['kap_kjs_id'] = 50;
                    $dataPembayaran['is_paid'] = true;
                    $dataPembayaran['masa_aktif'] = $masaAktif;

                    $sistem->saldo = $hasil;
                    $sistem->save();

                    $spt->status = SptStatusEnum::DILAPORKAN->value;
                    $spt->is_can_pembetulan = true;
                    $spt->save();

                    $pembayaran = Pembayaran::create($dataPembayaran);
                    return $pembayaran;
                }
            case IntentEnum::API_UPDATE_SPT_PPH_UNIFIKASI_BAYAR_KODE_BILLING->value:
                $sptunifikasi = SptUnifikasi::where('spt_id', $spt->id)->first();

                $spt->status = SptStatusEnum::MENUNGGU_PEMBAYARAN->value;
                $spt->is_can_pembetulan = true;
                $spt->save();

                $bayar = $sptunifikasi->cl_total_bayar ?? 0 ;

                $randomNumber = mt_rand(100000000000000, 999999999999999);

                $dataPembayaran = [
                    'nilai' => $bayar,
                    'masa_bulan' => $spt->masa_bulan,
                    'masa_tahun' => $spt->masa_tahun,
                    'badan_id' => $request['badan_id'],
                    'pic_id' => $request['pic_id'],
                    'kode_billing' => $randomNumber,
                    // 'kap_kjs_id' => $data['kap_kjs_id'],
                    'ntpn' => $ntpn,
                    'masa_aktif' => $masaAktif,
                    'spt_id' => $spt->id,
                ];

                Pembayaran::create($dataPembayaran);
                break;
            case IntentEnum::API_UPDATE_SPT_PPH_UNIFIKASI_BAYAR_DEPOSIT->value:
                $sistem = Sistem::find($sistem_id);

                $sptunifikasi = SptUnifikasi::where('spt_id', $spt->id)->first();

                $bayar = $sptunifikasi->cl_total_bayar ?? 0 ;

                $hasil = $sistem->saldo - $bayar;

                if ($hasil < 0) {
                    throw new \Exception('Saldo tidak mencukupi', 101);
                } else {
                    $dataPembayaran['nilai'] = $bayar;
                    $dataPembayaran['ntpn'] = $ntpn;
                    $dataPembayaran['masa_bulan'] = $spt->masa_bulan;
                    $dataPembayaran['masa_tahun'] = $spt->masa_tahun;
                    $dataPembayaran['badan_id'] = $request['badan_id'];
                    $dataPembayaran['pic_id'] = $request['pic_id'];
                    $dataPembayaran['ntpn'] = $ntpn;
                    // $dataPembayaran['kap_kjs_id'] = 50;
                    $dataPembayaran['is_paid'] = true;
                    $dataPembayaran['masa_aktif'] = $masaAktif;

                    $sistem->saldo = $hasil;
                    $sistem->save();

                    $spt->status = SptStatusEnum::DILAPORKAN->value;
                    $spt->is_can_pembetulan = true;
                    $spt->save();

                    $pembayaran = Pembayaran::create($dataPembayaran);
                    return $pembayaran;
                }
        }
        return $spt;
    }

    public function calculateSpt(Spt $spt, Request $request) {

        $month = $spt->masa_bulan;
        $year = $spt->masa_tahun;
        $pic = $spt->pic_id;

        $data['cl_1a1_dpp'] = $request['cl_1a1_dpp'];
        $data['cl_1a5_dpp'] = $request['cl_1a5_dpp'];
        $data['cl_1a9_dpp'] = $request['cl_1a9_dpp'];
        $data['cl_1a5_ppn'] = $request['cl_1a5_ppn'];
        $data['cl_1a9_ppn'] = $request['cl_1a9_ppn'];
        $data['cl_1a5_ppnbm'] = $request['cl_1a5_ppnbm'];
        $data['cl_1a9_ppnbm'] = $request['cl_1a9_ppnbm'];
        $data['cl_1b_jumlah_dpp'] = $request['cl_1b_jumlah_dpp'];
        $data['cl_2e_ppn'] = $request['cl_2e_ppn'];
        $data['cl_2h_dpp'] = $request['cl_2h_dpp'];
        $data['cl_2i_dpp'] = $request['cl_2i_dpp'];
        $data['cl_3b_ppn'] = $request['cl_3b_ppn'];
        $data['cl_3d_ppn'] = $request['cl_3d_ppn'];
        $data['cl_3f_ppn'] = $request['cl_3f_ppn'];
        $data['cl_6b_ppnbm'] = $request['cl_6b_ppnbm'];
        $data['cl_6d_ppnbm'] = $request['cl_6d_ppnbm'];
        $data['cl_7a_dpp'] = $request['cl_7a_dpp'];
        $data['cl_7b_dpp'] = $request['cl_7b_dpp'];
        $data['cl_7a_ppn'] = $request['cl_7a_ppn'];
        $data['cl_7b_ppn'] = $request['cl_7b_ppn'];
        $data['cl_7a_ppnbm'] = $request['cl_7a_ppnbm'];
        $data['cl_7b_ppnbm'] = $request['cl_7b_ppnbm'];
        $data['cl_7a_dpp_lain'] = $request['cl_7a_dpp_lain'];
        $data['cl_7b_dpp_lain'] = $request['cl_7b_dpp_lain'];
        $data['cl_8a_dpp'] = $request['cl_8a_dpp'];
        $data['cl_8b_dpp'] = $request['cl_8b_dpp'];
        $data['cl_8a_ppn'] = $request['cl_8a_ppn'];
        $data['cl_8b_ppn'] = $request['cl_8b_ppn'];
        $data['cl_8a_ppnbm'] = $request['cl_8a_ppnbm'];
        $data['cl_8b_ppnbm'] = $request['cl_8b_ppnbm'];
        $data['cl_8a_dpp_lain'] = $request['cl_8a_dpp_lain'];
        $data['cl_8b_dpp_lain'] = $request['cl_8b_dpp_lain'];
        $data['cl_5_ppn_wajib'] = $request['cl_5_ppn_wajib'];

        $data['cl_4_ppn_terutang_dpp'] = $request['cl_4_ppn_terutang_dpp'];
        $data['cl_1a9_dpp_lain'] = $request['cl_1a9_dpp_lain'];
        $data['cl_1a9_dpp_lain'] = $request['cl_1a9_dpp_lain'];
        $data['cl_2f_ppn'] = $request['cl_2f_ppn'];
        $data['cl_2e_ppn'] = $request['cl_2e_ppn'];

        $fakturs = Faktur::where('badan_id', $request['badan_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->get();

        // $data['cl_1a2_dpp'] dokumen lain

        $fakturs1a2 = $fakturs->whereIn('kode_transaksi', [4, 5]);
        $data['cl_1a2_dpp']      = $fakturs1a2->sum('dpp');
        $data['cl_1a2_dpp_lain'] = $fakturs1a2->sum('dpp_lain');
        $data['cl_1a2_ppn']      = $fakturs1a2->sum('ppn');
        $data['cl_1a2_ppnbm']    = $fakturs1a2->sum('ppnbm');

        $fakturs1a3 = $fakturs->where('kode_transaksi', 6);
        $data['cl_1a3_dpp']      = $fakturs1a3->sum('dpp');
        $data['cl_1a3_dpp_lain'] = $fakturs1a3->sum('dpp_lain');
        $data['cl_1a3_ppn']      = $fakturs1a3->sum('ppn');
        $data['cl_1a3_ppnbm']    = $fakturs1a3->sum('ppnbm');

        $fakturs1a4 = $fakturs->whereIn('kode_transaksi', [1, 9, 10]);
        $data['cl_1a4_dpp']      = $fakturs1a4->sum('dpp');
        $data['cl_1a4_ppn']      = $fakturs1a4->sum('ppn');
        $data['cl_1a4_ppnbm']    = $fakturs1a4->sum('ppnbm');

        $fakturs1a6 = $fakturs->whereIn('kode_transaksi', [2, 3]);
        $data['cl_1a6_dpp']      = $fakturs1a6->sum('dpp');
        $data['cl_1a6_dpp_lain'] = $fakturs1a6->sum('dpp_lain');
        $data['cl_1a6_ppn']      = $fakturs1a6->sum('ppn');
        $data['cl_1a6_ppnbm']    = $fakturs1a6->sum('ppnbm');

        $fakturs1a7 = $fakturs->where('kode_transaksi', 7);
        $data['cl_1a7_dpp']      = $fakturs1a7->sum('dpp');
        $data['cl_1a7_dpp_lain'] = $fakturs1a7->sum('dpp_lain');
        $data['cl_1a7_ppn']      = $fakturs1a7->sum('ppn');
        $data['cl_1a7_ppnbm']    = $fakturs1a7->sum('ppnbm');

        $fakturs1a8 = $fakturs->where('kode_transaksi', 8);
        $data['cl_1a8_dpp']      = $fakturs1a8->sum('dpp');
        $data['cl_1a8_dpp_lain'] = $fakturs1a8->sum('dpp_lain');
        $data['cl_1a8_ppn']      = $fakturs1a8->sum('ppn');
        $data['cl_1a8_ppnbm']    = $fakturs1a8->sum('ppnbm');

        $data['cl_1a_jumlah_dpp'] =
           ($data['cl_1a1_dpp'] ?? 0)
         + ($data['cl_1a2_dpp'] ?? 0)
         + ($data['cl_1a3_dpp'] ?? 0)
         + ($data['cl_1a4_dpp'] ?? 0)
         + ($data['cl_1a5_dpp'] ?? 0)
         + ($data['cl_1a6_dpp'] ?? 0)
         + ($data['cl_1a7_dpp'] ?? 0)
         + ($data['cl_1a8_dpp'] ?? 0)
         + ($data['cl_1a9_dpp'] ?? 0);

        $data['cl_1a_jumlah_ppn'] =
           ($data['cl_1a2_ppn'] ?? 0)
         + ($data['cl_1a3_ppn'] ?? 0)
         + ($data['cl_1a4_ppn'] ?? 0)
         + ($data['cl_1a5_ppn'] ?? 0)
         + ($data['cl_1a6_ppn'] ?? 0)
         + ($data['cl_1a7_ppn'] ?? 0)
         + ($data['cl_1a8_ppn'] ?? 0)
         + ($data['cl_1a9_ppn'] ?? 0);

         $data['cl_1a_jumlah_ppnbm'] =
           ($data['cl_1a2_ppnbm'] ?? 0)
         + ($data['cl_1a3_ppnbm'] ?? 0)
         + ($data['cl_1a5_ppnbm'] ?? 0)
         + ($data['cl_1a6_ppnbm'] ?? 0)
         + ($data['cl_1a7_ppnbm'] ?? 0)
         + ($data['cl_1a8_ppnbm'] ?? 0)
         + ($data['cl_1a9_ppnbm'] ?? 0);

        $data['cl_1c_jumlah_dpp'] = $data['cl_1a_jumlah_dpp'] + ($data['cl_1b_jumlah_dpp'] ?? 0);

        $faktursMasukan = Faktur::where('akun_penerima_id', $request['badan_id'])
            ->where('masa_pajak', $month)
            ->where('tahun', $year)
            ->where('status', FakturStatusEnum::APPROVED->value)
            ->where('is_kredit', true)
            ->get();

        $fakturs2b = $faktursMasukan->whereIn('kode_transaksi', [4, 5]);
        $data['cl_2b_dpp']      = $fakturs2b->sum('dpp');
        $data['cl_2b_dpp_lain'] = $fakturs2b->sum('dpp_lain') + $fakturs2b->sum('dpp_lain_retur');
        $data['cl_2b_ppn']      = $fakturs2b->sum('ppn') + $fakturs2b->sum('ppn_retur');
        $data['cl_2b_ppnbm']    = $fakturs2b->sum('ppnbm') + $fakturs2b->sum('ppnbm_retur');

        $fakturs2c = $faktursMasukan->whereIn('kode_transaksi', [1, 9, 10]);
        $data['cl_2c_dpp']      = $fakturs2c->sum('dpp');
        $data['cl_2c_ppn']      = $fakturs2c->sum('ppn') + $fakturs2c->sum('ppn_retur');
        $data['cl_2c_ppnbm']    = $fakturs2c->sum('ppnbm') + $fakturs2c->sum('ppnbm_retur');

        $fakturs2d = $faktursMasukan->whereIn('kode_transaksi', [2, 3]);
        $data['cl_2d_dpp']      = $fakturs2d->sum('dpp');
        $data['cl_2d_dpp_lain'] = $fakturs2d->sum('dpp_lain') + $fakturs2d->sum('dpp_lain_retur');
        $data['cl_2d_ppn']      = $fakturs2d->sum('ppn') + $fakturs2d->sum('ppn_retur');
        $data['cl_2d_ppnbm']    = $fakturs2d->sum('ppnbm') + $fakturs2d->sum('ppnbm_retur');

         $data['cl_2g_dpp'] =
           ($data['cl_2a_dpp'] ?? 0)
         + ($data['cl_2b_dpp'] ?? 0)
         + ($data['cl_2c_dpp'] ?? 0)
         + ($data['cl_2d_dpp'] ?? 0);

         $data['cl_2g_ppn'] =
            ($data['cl_2a_ppn'] ?? 0)
         + ($data['cl_2b_ppn'] ?? 0)
         + ($data['cl_2c_ppn'] ?? 0)
         + ($data['cl_2d_ppn'] ?? 0);
         + ($data['cl_2e_ppn'] ?? 0);

         $data['cl_2j_dpp'] = ($data['cl_2g_dpp'] ?? 0 ) + ($data['cl_2h_dpp'] ?? 0 ) + ($data['cl_2i_dpp'] ?? 0 );

         $data['cl_3a_ppn'] = ($data['cl_1a2_ppn'] ?? 0) + ($data['cl_1a3_ppn'] ?? 0) + ($data['cl_1a4_ppn'] ?? 0) + ($data['cl_1a5_ppn'] ?? 0);
         $data['cl_3c_ppn'] = ($data['cl_2g_ppn'] ?? 0);
         $data['cl_3e_ppn'] = ($data['cl_3a_ppn'] ?? 0) - ($data['cl_3b_ppn'] ?? 0) - ($data['cl_3c_ppn'] ?? 0) - ($data['cl_3c_ppn'] ?? 0);
         $data['cl_3g_ppn'] = ($data['cl_3e_ppn'] ?? 0) - ($data['cl_3f_ppn'] ?? 0);

         if ($data['cl_3g_ppn'] < 0){
            $data['cl_3h_diminta'] = '0';
         }

         $cl_4_ppn_terutang_dpp = ($request['cl_4_ppn_terutang_dpp'] ?? 0);
         $data['cl_4_ppn_terutang'] = $cl_4_ppn_terutang_dpp * 0.12;

         $data['cl_6a_ppnbm'] = ($data['cl_1a2_ppnbm'] ?? 0) + ($data['cl_1a3_ppnbm'] ?? 0) + ($data['cl_1a4_ppnbm'] ?? 0) + ($data['cl_1a5_ppnbm'] ?? 0);
         $data['cl_6c_ppnbm'] = ($data['cl_6a_ppnbm'] ?? 0) - ($data['cl_6b_ppnbm'] ?? 0);
         $data['cl_6e_ppnbm'] = ($data['cl_6c_ppnbm'] ?? 0) - ($data['cl_6d_ppnbm'] ?? 0);
         $data['cl_6f_diminta_pengembalian'] = $data['cl_6e_ppnbm'] < 0;

         $data['cl_7c_dpp'] = ($data['cl_7a_dpp'] ?? 0) - ($data['cl_7b_dpp'] ?? 0);
         $data['cl_7c_ppn'] = ($data['cl_7a_ppn'] ?? 0) - ($data['cl_7b_ppn'] ?? 0);
         $data['cl_7c_ppnbm'] = ($data['cl_7a_ppnbm'] ?? 0) - ($data['cl_7b_ppnbm'] ?? 0);
         $data['cl_7c_dpp_lain'] = ($data['cl_7a_dpp_lain'] ?? 0) - ($data['cl_7b_dpp_lain'] ?? 0);

         $data['cl_8c_dpp'] = ($data['cl_8a_dpp'] ?? 0) - ($data['cl_8b_dpp'] ?? 0);
         $data['cl_8c_ppn'] = ($data['cl_8a_ppn'] ?? 0) - ($data['cl_8b_ppn'] ?? 0);
         $data['cl_8c_ppnbm'] = ($data['cl_8a_ppnbm'] ?? 0) - ($data['cl_8b_ppnbm'] ?? 0);
         $data['cl_8c_dpp_lain'] = ($data['cl_8a_dpp_lain'] ?? 0) - ($data['cl_8b_dpp_lain'] ?? 0);

        $sptPpn = SptPpn::where('spt_id', $spt->id)->first();
        $skipKeys = ['badan_id'];
        foreach ($data as $key => $value) {
            if (in_array($key, $skipKeys)) continue;
            $sptPpn->$key = $value;
        }

        $sptPpn->save();
        //isi sendiri 1a5 1a9 1b 2e 2f 2h 2i 3b 3d 3f 4 5 6b 6d 7a 7b 8 8ba
        //calculate 1c 2g 2j 3g 3h 4 6a 6c 6f 7c 8c
        return $sptPpn;
    }

    public function getAllForSpt(Sistem $sistem, int $perPage, array $filters = []) {
        $query = Spt::where('badan_id', $sistem->id);

        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $spts = $query->paginate($perPage);

        return $spts;
    }

    public function showDetailSpt(Spt $spt) {
        switch ($spt->jenis_pajak) {
            case JenisPajakEnum::PPN->value:
                $spt->load('spt_ppn');
                break;
            case JenisPajakEnum::PPH->value:
                $spt->load('spt_pph');
                break;
            case JenisPajakEnum::PPH_UNIFIKASI->value:
                $spt->load('spt_unifikasi');
                break;
            case JenisPajakEnum::PPH_BADAN->value:
                // $spt->load('sptTahunan');
                break;
        }

        return new SptResource($spt);
    }

    public function create(array $data): Model{
        $month = $data['masa_bulan'];
        $year = $data['masa_tahun'];
        $pic = $data['pic_id'];

        $data['is_can_pembetulan'] = false;
        $data['tanggal_dibuat'] = Carbon::now()->format('Y-m-d');
        $data['status'] = SptStatusEnum::KONSEP->value;

        if ($data['jenis_pajak'] == JenisPajakEnum::PPN->value || JenisPajakEnum::PPH->value) {
            $data['tanggal_jatuh_tempo'] = Carbon::now()->addMonth()->format('Y-m-d');
        }

        $spt = parent::create($data);

        switch ($data['jenis_pajak']) {
            case JenisPajakEnum::PPN->value:

                $fakturs = Faktur::where('badan_id', $data['badan_id'])
                ->where('masa_pajak', $month)
                ->where('tahun', $year)
                ->where('status', FakturStatusEnum::APPROVED->value)
                ->get();

                // $data['cl_1a2_dpp'] dokumen lain

                $fakturs1a2 = $fakturs->whereIn('kode_transaksi', [4, 5]);
                $data_spt_ppn['cl_1a2_dpp']      = $fakturs1a2->sum('dpp');
                $data_spt_ppn['cl_1a2_dpp_lain'] = $fakturs1a2->sum('dpp_lain');
                $data_spt_ppn['cl_1a2_ppn']      = $fakturs1a2->sum('ppn');
                $data_spt_ppn['cl_1a2_ppnbm']    = $fakturs1a2->sum('ppnbm');

                $fakturs1a3 = $fakturs->where('kode_transaksi', 6);
                $data_spt_ppn['cl_1a3_dpp']      = $fakturs1a3->sum('dpp');
                $data_spt_ppn['cl_1a3_dpp_lain'] = $fakturs1a3->sum('dpp_lain');
                $data_spt_ppn['cl_1a3_ppn']      = $fakturs1a3->sum('ppn');
                $data_spt_ppn['cl_1a3_ppnbm']    = $fakturs1a3->sum('ppnbm');

                $fakturs1a4 = $fakturs->whereIn('kode_transaksi', [1, 9, 10]);
                $data_spt_ppn['cl_1a4_dpp']      = $fakturs1a4->sum('dpp');
                $data_spt_ppn['cl_1a4_ppn']      = $fakturs1a4->sum('ppn');
                $data_spt_ppn['cl_1a4_ppnbm']    = $fakturs1a4->sum('ppnbm');

                $fakturs1a6 = $fakturs->whereIn('kode_transaksi', [2, 3]);
                $data_spt_ppn['cl_1a6_dpp']      = $fakturs1a6->sum('dpp');
                $data_spt_ppn['cl_1a6_dpp_lain'] = $fakturs1a6->sum('dpp_lain');
                $data_spt_ppn['cl_1a6_ppn']      = $fakturs1a6->sum('ppn');
                $data_spt_ppn['cl_1a6_ppnbm']    = $fakturs1a6->sum('ppnbm');

                $fakturs1a7 = $fakturs->where('kode_transaksi', 7);
                $data_spt_ppn['cl_1a7_dpp']      = $fakturs1a7->sum('dpp');
                $data_spt_ppn['cl_1a7_dpp_lain'] = $fakturs1a7->sum('dpp_lain');
                $data_spt_ppn['cl_1a7_ppn']      = $fakturs1a7->sum('ppn');
                $data_spt_ppn['cl_1a7_ppnbm']    = $fakturs1a7->sum('ppnbm');

                $fakturs1a8 = $fakturs->where('kode_transaksi', 8);
                $data_spt_ppn['cl_1a8_dpp']      = $fakturs1a8->sum('dpp');
                $data_spt_ppn['cl_1a8_dpp_lain'] = $fakturs1a8->sum('dpp_lain');
                $data_spt_ppn['cl_1a8_ppn']      = $fakturs1a8->sum('ppn');
                $data_spt_ppn['cl_1a8_ppnbm']    = $fakturs1a8->sum('ppnbm');

                $faktursMasukan = Faktur::where('akun_penerima_id', $data['badan_id'])
                    ->where('masa_pajak', $month)
                    ->where('tahun', $year)
                    ->where('status', FakturStatusEnum::APPROVED->value)
                    ->where('is_kredit', true)
                    ->get();

                $fakturs2b = $faktursMasukan->whereIn('kode_transaksi', [4, 5]);
                $data_spt_ppn['cl_2b_dpp']      = $fakturs2b->sum('dpp');
                $data_spt_ppn['cl_2b_dpp_lain'] = $fakturs2b->sum('dpp_lain') + $fakturs2b->sum('dpp_lain_retur');
                $data_spt_ppn['cl_2b_ppn']      = $fakturs2b->sum('ppn') + $fakturs2b->sum('ppn_retur');
                $data_spt_ppn['cl_2b_ppnbm']    = $fakturs2b->sum('ppnbm') + $fakturs2b->sum('ppnbm_retur');

                $fakturs2c = $faktursMasukan->whereIn('kode_transaksi', [1, 9, 10]);
                $data_spt_ppn['cl_2c_dpp']      = $fakturs2c->sum('dpp');
                $data_spt_ppn['cl_2c_ppn']      = $fakturs2c->sum('ppn') + $fakturs2c->sum('ppn_retur');
                $data_spt_ppn['cl_2c_ppnbm']    = $fakturs2c->sum('ppnbm') + $fakturs2c->sum('ppnbm_retur');

                $fakturs2d = $faktursMasukan->whereIn('kode_transaksi', [2, 3]);
                $data_spt_ppn['cl_2d_dpp']      = $fakturs2d->sum('dpp');
                $data_spt_ppn['cl_2d_dpp_lain'] = $fakturs2d->sum('dpp_lain') + $fakturs2d->sum('dpp_lain_retur');
                $data_spt_ppn['cl_2d_ppn']      = $fakturs2d->sum('ppn') + $fakturs2d->sum('ppn_retur');
                $data_spt_ppn['cl_2d_ppnbm']    = $fakturs2d->sum('ppnbm') + $fakturs2d->sum('ppnbm_retur');

                $data_spt_ppn['spt_id'] = $spt->id;

                //for pajak masukan retur
                SptPpn::create($data_spt_ppn);
                break;
            case JenisPajakEnum::PPH->value:
                $monthNumber = MonthHelper::getMonthNumber($month);

                $bupots = Bupot::where('pembuat_id', $data['badan_id'])
                ->whereMonth('masa_awal', $monthNumber)
                ->whereYear('masa_awal', $year)
                ->get();

                $data_spt_pph = [];

                $total_pemotongan_lain = $bupots->where('tipe_bupot', BupotTypeEnum::BPBPT->value)
                    ->where('fasilitas_pajak', 'Pph Ditanggung Pemerintah (DTP)');
                $total_pemotongan_normal = $bupots->where('tipe_bupot', BupotTypeEnum::BPBPT->value)
                    ->where('fasilitas_pajak', '!=', 'Pph Ditanggung Pemerintah (DTP)');
                $total_bp21 = $bupots->where('tipe_bupot', BupotTypeEnum::BP21->value);
                $total_bp26 = $bupots->where('tipe_bupot', BupotTypeEnum::BP26->value);

                $a = $total_pemotongan_normal->sum('pajak_penghasilan') ?? 0;
                $b = $total_bp21->sum('pajak_penghasilan') ?? 0;
                $data_spt_pph['cl_bp1_1'] = $a + $b;

                $c = $total_pemotongan_lain->sum('pajak_penghasilan') ?? 0;
                $d = $total_bp21->sum('pajak_penghasilan') ?? 0;
                $data_spt_pph['cl_bp1_7'] = $c + $d;

                $e = $total_pemotongan_normal->where('status', 'pembetulan')->sum('pajak_penghasilan') ?? 0;
                $f = $total_bp21->where('status', 'pembetulan')->sum('pajak_penghasilan') ?? 0;
                $data_spt_pph['cl_bp1_5'] = $e + $f;

                $a2 = $total_pemotongan_normal->sum('pajak_penghasilan') ?? 0;
                $b2 = $total_bp26->sum('pajak_penghasilan') ?? 0;
                $data_spt_pph['cl_bp2_1'] = $a2 + $b2;

                $c2 = $total_pemotongan_lain->sum('pajak_penghasilan') ?? 0;
                $d2 = $total_bp26->sum('pajak_penghasilan') ?? 0;
                $data_spt_pph['cl_bp2_7'] = $c2 + $d2;

                $e2 = $total_pemotongan_normal->where('status', 'pembetulan')->sum('pajak_penghasilan') ?? 0;
                $f2 = $total_bp26->where('status', 'pembetulan')->sum('pajak_penghasilan') ?? 0;
                $data_spt_pph['cl_bp2_5'] = $e2 + $f2;

                $data_spt_pph['spt_id'] = $spt->id;

                SptPph::create($data_spt_pph);
                break;
            case JenisPajakEnum::PPH_UNIFIKASI->value:
                $monthNumber = MonthHelper::getMonthNumber($month);

                $bupots = Bupot::where('pembuat_id', $data['badan_id'])
                ->whereMonth('masa_awal', $monthNumber)
                ->whereYear('masa_awal', $year)
                ->get();

                $data_spt_uni = [];

                $bupot_tanggung = $bupots->where('tipe_bupot',[BupotTypeEnum::BPPU->value, BupotTypeEnum::BPNR->value, BupotTypeEnum::PS->value])
                    ->where('fasilitas_pajak', 'Pph Ditanggung Pemerintah (DTP)');
                $bupot_lain_sendiri = $bupots->where('tipe_bupot', BupotTypeEnum::PS->value)
                    ->where('fasilitas_pajak', '!=', 'Pph Ditanggung Pemerintah (DTP)');
                $bupot_lain = $bupots->whereIn('tipe_bupot', [BupotTypeEnum::BPPU->value, BupotTypeEnum::BPNR->value])
                    ->where('fasilitas_pajak', '!=', 'Pph Ditanggung Pemerintah (DTP)');

                $data_spt_uni['cl_a_1'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_1'] = $bupot_lain->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_1'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_1'] = $data_spt_uni['cl_a_1'] + $data_spt_uni['cl_b_1'] + $data_spt_uni['cl_c_1'];

                $data_spt_uni['cl_a_2'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-402')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_2'] = $bupot_lain->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-402')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_2'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-402')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_2'] = $data_spt_uni['cl_a_2'] + $data_spt_uni['cl_b_2'] + $data_spt_uni['cl_c_2'];

                $data_spt_uni['cl_a_3'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-403')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_3'] = $bupot_lain->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-403')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_3'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 4 Ayat 2')
                                                            ->where('kap', '411128-403')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_3'] = $data_spt_uni['cl_a_3'] + $data_spt_uni['cl_b_3'] + $data_spt_uni['cl_c_3'];

                $data_spt_uni['cl_a_pasal4'] = $data_spt_uni['cl_a_1'] + $data_spt_uni['cl_a_2'] + $data_spt_uni['cl_a_3'];
                $data_spt_uni['cl_b_pasal4'] = $data_spt_uni['cl_b_1'] + $data_spt_uni['cl_b_2'] + $data_spt_uni['cl_b_3'];
                $data_spt_uni['cl_c_pasal4'] = $data_spt_uni['cl_c_1'] + $data_spt_uni['cl_c_2'] + $data_spt_uni['cl_c_3'];
                $data_spt_uni['cl_d_pasal4'] = $data_spt_uni['cl_d_1'] + $data_spt_uni['cl_d_2'] + $data_spt_uni['cl_d_3'];

                $data_spt_uni['cl_a_4'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 15')
                                                            ->where('kap', '411128-600')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_4'] = $bupot_lain->where('jenis_pajak', 'Pasal 15')
                                                            ->where('kap', '411128-600')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_4'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 15')
                                                            ->where('kap', '411128-600')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_4'] = $data_spt_uni['cl_a_4'] + $data_spt_uni['cl_b_4'] + $data_spt_uni['cl_c_4'];

                $data_spt_uni['cl_a_5'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 15')
                                                            ->where('kap', '411129-600')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_5'] = $bupot_lain->where('jenis_pajak', 'Pasal 15')
                                                            ->where('kap', '411129-600')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_5'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 15')
                                                            ->where('kap', '411129-600')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_5'] = $data_spt_uni['cl_a_5'] + $data_spt_uni['cl_b_5'] + $data_spt_uni['cl_c_5'];

                $data_spt_uni['cl_a_pasal15'] = $data_spt_uni['cl_a_4'] + $data_spt_uni['cl_a_5'];
                $data_spt_uni['cl_b_pasal15'] = $data_spt_uni['cl_b_4'] + $data_spt_uni['cl_b_5'];
                $data_spt_uni['cl_c_pasal15'] = $data_spt_uni['cl_c_4'] + $data_spt_uni['cl_c_5'];
                $data_spt_uni['cl_d_pasal15'] = $data_spt_uni['cl_d_4'] + $data_spt_uni['cl_d_5'];

                $data_spt_uni['cl_a_6'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411122-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_6'] = $bupot_lain->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411122-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_6'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411122-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_6'] = $data_spt_uni['cl_a_6'] + $data_spt_uni['cl_b_6'] + $data_spt_uni['cl_c_6'];

                $data_spt_uni['cl_a_7'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411122-900')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_7'] = $bupot_lain->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411122-900')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_7'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411122-900')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_7'] = $data_spt_uni['cl_a_7'] + $data_spt_uni['cl_b_7'] + $data_spt_uni['cl_c_7'];

                $data_spt_uni['cl_a_8'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411128-403')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_8'] = $bupot_lain->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411128-403')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_8'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 22')
                                                            ->where('kap', '411128-403')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_8'] = $data_spt_uni['cl_a_8'] + $data_spt_uni['cl_b_8'] + $data_spt_uni['cl_c_8'];

                $data_spt_uni['cl_a_pasal22'] = $data_spt_uni['cl_a_6'] + $data_spt_uni['cl_a_7'] + $data_spt_uni['cl_a_8'];
                $data_spt_uni['cl_b_pasal22'] = $data_spt_uni['cl_b_6'] + $data_spt_uni['cl_b_7'] + $data_spt_uni['cl_b_8'];
                $data_spt_uni['cl_c_pasal22'] = $data_spt_uni['cl_c_6'] + $data_spt_uni['cl_c_7'] + $data_spt_uni['cl_c_8'];
                $data_spt_uni['cl_d_pasal22'] = $data_spt_uni['cl_d_6'] + $data_spt_uni['cl_d_7'] + $data_spt_uni['cl_d_8'];

                $data_spt_uni['cl_a_9'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 23')
                                                            ->where('kap', '411124-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_9'] = $bupot_lain->where('jenis_pajak', 'Pasal 23')
                                                            ->where('kap', '411124-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_9'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 23')
                                                            ->where('kap', '411124-100')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_9'] = $data_spt_uni['cl_a_9'] + $data_spt_uni['cl_b_9'] + $data_spt_uni['cl_c_9'];

                $data_spt_uni['cl_a_pasal23'] = $data_spt_uni['cl_a_9'];
                $data_spt_uni['cl_b_pasal23'] = $data_spt_uni['cl_b_9'];
                $data_spt_uni['cl_c_pasal23'] = $data_spt_uni['cl_c_9'];
                $data_spt_uni['cl_d_pasal23'] = $data_spt_uni['cl_d_9'];

                $data_spt_uni['cl_a_10'] = $bupot_lain_sendiri->where('jenis_pajak', 'Pasal 26')
                                                            ->where('kap', '411127-110')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_b_10'] = $bupot_lain->where('jenis_pajak', 'Pasal 26')
                                                            ->where('kap', '411127-110')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_c_10'] = $bupot_tanggung->where('jenis_pajak', 'Pasal 26')
                                                            ->where('kap', '411127-110')
                                                            ->sum('pajak_penghasilan');

                $data_spt_uni['cl_d_10'] = $data_spt_uni['cl_a_10'] + $data_spt_uni['cl_b_10'] + $data_spt_uni['cl_c_10'];

                $data_spt_uni['cl_a_pasal26'] = $data_spt_uni['cl_a_10'];
                $data_spt_uni['cl_b_pasal26'] = $data_spt_uni['cl_b_10'];
                $data_spt_uni['cl_c_pasal26'] = $data_spt_uni['cl_c_10'];
                $data_spt_uni['cl_d_pasal26'] = $data_spt_uni['cl_d_10'];

                $data_spt_uni['cl_total_setor'] = $data_spt_uni['cl_a_pasal4'] + $data_spt_uni['cl_a_pasal15'] + $data_spt_uni['cl_a_pasal22'] + $data_spt_uni['cl_a_pasal23'] + $data_spt_uni['cl_a_pasal26'];
                $data_spt_uni['cl_total_potong'] = $data_spt_uni['cl_b_pasal4'] + $data_spt_uni['cl_b_pasal15'] + $data_spt_uni['cl_b_pasal22'] + $data_spt_uni['cl_b_pasal23'] + $data_spt_uni['cl_b_pasal26'];
                $data_spt_uni['cl_total_tanggung'] = $data_spt_uni['cl_c_pasal4'] + $data_spt_uni['cl_c_pasal15'] + $data_spt_uni['cl_c_pasal22'] + $data_spt_uni['cl_c_pasal23'] + $data_spt_uni['cl_c_pasal26'];
                $data_spt_uni['cl_total_bayar'] = $data_spt_uni['cl_d_pasal4'] + $data_spt_uni['cl_d_pasal15'] + $data_spt_uni['cl_d_pasal22'] + $data_spt_uni['cl_d_pasal23'] + $data_spt_uni['cl_d_pasal26'];

                $data_spt_uni['spt_id'] = $spt->id;

                SptUnifikasi::create($data_spt_uni);
                break;
        }
        return $spt;
    }

    public function authorizeAccess(Assignment $assignment, Sistem $sistem): void
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => Auth::id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403, 'Unauthorized access to this sistem');
        }
        // Verify the sistem exists for this assignment user
        Sistem::where('assignment_user_id', $assignmentUser->id)
        ->where('id', $sistem->id)
        ->firstOrFail();
    }

    public function checkPeriode(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->authorizeAccess($assignment, $sistem);

        $picId = $request->query('pic_id');
        $bulan = $request->query('masa_bulan');
        $tahun = $request->query('masa_tahun');
        $jenis_pajak = $request->query('jenis_pajak');

        $pic = Sistem::where('id', $picId)->first();
        if (!$pic) {
            abort(404, 'Belum ada PIC');
        }

        $picId = $pic->id;

        $check = Spt::where('pic_id', $picId)
                       ->where('jenis_pajak', $jenis_pajak)
                       ->where('masa_bulan', $bulan)
                       ->where('masa_tahun', $tahun)
                       ->latest()->first();

        // return $check;
        if (empty($check)) {
            return [
                //alur normal
                'masa_bulan' => $bulan,
                'masa_tahun' => $tahun,
                'jenis_pajak' => $jenis_pajak,
                'model' => SptModelEnum::NORMAL->value,
            ];
        }else {
            if (!$check->is_can_pembetulan) {
                return response()->json([
                    'message' => 'Spt Dalam Kondisi Konsep',
                    'code' => 101,
                ]);
            }else {
                //alur pembetulan
                return [
                    'model' => SptModelEnum::PEMBETULAN->value,
                    'masa_bulan' => $bulan,
                    'masa_tahun' => $tahun,
                    'jenis_pajak' => $jenis_pajak,
                ];
            }
        }
    }

    public function showFakturSptPpn($spt, Request $request) {

        $fakturKeluaran = Faktur::where('badan_id', $request['badan_id'])
                        ->where('status', FakturStatusEnum::APPROVED->value)
                        ->where('masa_pajak', $spt->masa_bulan)
                        ->where('tahun', $spt->masa_tahun)
                        ->get();

        $fakturMasukan = Faktur::where('akun_penerima_id', $request['badan_id'])
                        ->where('status', FakturStatusEnum::APPROVED->value)
                        ->where('masa_pajak', $spt->masa_bulan)
                        ->where('tahun', $spt->masa_tahun)
                        ->get();

        $jenisSptPpn = $request['jenis_spt_ppn'];

        switch ($jenisSptPpn) {
            case JenisSptPpnEnum::A1->value:
                // return FakturResource::collection($fakturKeluaran);
            case JenisSptPpnEnum::A2->value:
                return FakturResource::collection($fakturKeluaran);
            case JenisSptPpnEnum::B1->value:
                // return FakturResource::collection($fakturKeluaran);
            case JenisSptPpnEnum::B2->value:
                $fakturMasukanB2 = $fakturMasukan->whereIn('kode_transaksi', [1, 2, 3, 4, 5, 6, 9, 10])->where('is_kredit', true);
                return FakturResource::collection($fakturMasukanB2);
            case JenisSptPpnEnum::B3->value:
                $fakturMasukanB2 = $fakturMasukan->whereIn('kode_transaksi', [7, 8])->where('is_kredit', true);
                return FakturResource::collection($fakturMasukanB2);
            case JenisSptPpnEnum::C->value:
                $fakturMasukanC = $fakturMasukan->filter(fn($f) => $f->ppnbm === null || $f->ppnbm = 0);
                return FakturResource::collection($fakturMasukanC);
            default:
                return response()->json([
                    'message' => 'Intent tidak valid',
                ], 400);
        }
    }

    public function showBupotSptPph($spt, Request $request) {
        $month = $spt->masa_bulan;
        $monthNumber = MonthHelper::getMonthNumber($month);

        $bupots = Bupot::where('pembuat_id', $spt->badan_id)
                ->whereMonth('masa_awal', $monthNumber)
                ->whereYear('masa_awal', $spt->masa_tahun)
                ->get();

        $jenisSptPph = $request['jenis_spt_pph'];
        // dd($jenisSptPph);

        switch ($jenisSptPph) {
            case JenisSptPphEnum::L1->value:
                $bpbpt = $bupots->where('tipe_bupot', BupotTypeEnum::BPBPT->value);
                return BupotResource::collection($bpbpt);
            case JenisSptPphEnum::L3->value:
               $combinedBupots = $bupots->whereIn('tipe_bupot', [
                BupotTypeEnum::BP21->value,
                BupotTypeEnum::BP26->value
            ]);
                return BupotResource::collection($combinedBupots);
            default:
                return response()->json([
                    'message' => 'Intent tidak valid',
                ], 400);
        }
    }

    public function showBupotSptPphUnifikasi($spt, Request $request) {
        $month = $spt->masa_bulan;
        $monthNumber = MonthHelper::getMonthNumber($month);

        $bupots = Bupot::where('pembuat_id', $spt->badan_id)
                ->whereMonth('masa_awal', $monthNumber)
                ->whereYear('masa_awal', $spt->masa_tahun)
                ->get();

        $jenisSptPph = $request['jenis_spt_pph'];

        switch ($jenisSptPph) {
            case JenisSptPphUnifikasiEnum::DAFTAR_1->value:
               $combinedBupots = $bupots->whereIn('tipe_bupot', [
                BupotTypeEnum::BPPU->value,
                BupotTypeEnum::BPNR->value
            ]);
                return BupotResource::collection($combinedBupots);
            case JenisSptPphUnifikasiEnum::DAFTAR_2->value:
                $ps  = $bupots->where('tipe_bupot', BupotTypeEnum::PS->value);
                return BupotResource::collection($ps);
            default:
                return response()->json([
                    'message' => 'Intent tidak valid',
                ], 400);
        }
    }

    public function calculateSptbackup(Spt $spt, Request $request) {

    //     $data['cl_1a1_dpp'] = $request['cl_1a1_dpp'];
    //     $data['cl_1a5_dpp'] = $request['cl_1a5_dpp'];
    //     $data['cl_1a9_dpp'] = $request['cl_1a9_dpp'];
    //     $data['cl_1a5_ppn'] = $request['cl_1a5_ppn'];
    //     $data['cl_1a9_ppn'] = $request['cl_1a9_ppn'];
    //     $data['cl_1a5_ppnbm'] = $request['cl_1a5_ppnbm'];
    //     $data['cl_1a9_ppnbm'] = $request['cl_1a9_ppnbm'];
    //     $data['cl_2e_ppn'] = $request['cl_2e_ppn'];
    //     $data['cl_2h_dpp'] = $request['cl_2h_dpp'];
    //     $data['cl_2i_dpp'] = $request['cl_2i_dpp'];
    //     $data['cl_3b_ppn'] = $request['cl_3b_ppn'];
    //     $data['cl_3d_ppn'] = $request['cl_3d_ppn'];
    //     $data['cl_3f_ppn'] = $request['cl_3f_ppn'];
    //     $data['cl_6b_ppnbm'] = $request['cl_6b_ppnbm'];
    //     $data['cl_6d_ppnbm'] = $request['cl_6d_ppnbm'];
    //     $data['cl_7a_dpp'] = $request['cl_7a_dpp'];
    //     $data['cl_7b_dpp'] = $request['cl_7b_dpp'];
    //     $data['cl_7a_ppn'] = $request['cl_7a_ppn'];
    //     $data['cl_7b_ppn'] = $request['cl_7b_ppn'];
    //     $data['cl_7a_ppnbm'] = $request['cl_7a_ppnbm'];
    //     $data['cl_7b_ppnbm'] = $request['cl_7b_ppnbm'];
    //     $data['cl_7a_dpp_lain'] = $request['cl_7a_dpp_lain'];
    //     $data['cl_7b_dpp_lain'] = $request['cl_7b_dpp_lain'];
    //     $data['cl_8a_dpp'] = $request['cl_8a_dpp'];
    //     $data['cl_8b_dpp'] = $request['cl_8b_dpp'];
    //     $data['cl_8a_ppn'] = $request['cl_8a_ppn'];
    //     $data['cl_8b_ppn'] = $request['cl_8b_ppn'];
    //     $data['cl_8a_ppnbm'] = $request['cl_8a_ppnbm'];
    //     $data['cl_8b_ppnbm'] = $request['cl_8b_ppnbm'];
    //     $data['cl_8a_dpp_lain'] = $request['cl_8a_dpp_lain'];
    //     $data['cl_8b_dpp_lain'] = $request['cl_8b_dpp_lain'];

    //     $data['cl_1a_jumlah_dpp'] =
    //        ($data['cl_1a1_dpp'] ?? 0)
    //      + ($data['cl_1a2_dpp'] ?? 0)
    //      + ($data['cl_1a3_dpp'] ?? 0)
    //      + ($data['cl_1a4_dpp'] ?? 0)
    //      + ($request['cl_1a5_dpp'] ?? 0)
    //      + ($data['cl_1a6_dpp'] ?? 0)
    //      + ($data['cl_1a7_dpp'] ?? 0)
    //      + ($data['cl_1a8_dpp'] ?? 0)
    //      + ($request['cl_1a9_dpp'] ?? 0);

    //     $data['cl_1a_jumlah_ppn'] =
    //        ($data['cl_1a2_ppn'] ?? 0)
    //      + ($data['cl_1a3_ppn'] ?? 0)
    //      + ($request['cl_1a5_ppn'] ?? 0)
    //      + ($data['cl_1a6_ppn'] ?? 0)
    //      + ($data['cl_1a7_ppn'] ?? 0)
    //      + ($data['cl_1a8_ppn'] ?? 0)
    //      + ($request['cl_1a9_ppn'] ?? 0);

    //      $data['cl_1a_jumlah_ppnbm'] =
    //        ($data['cl_1a2_ppnbm'] ?? 0)
    //      + ($data['cl_1a3_ppnbm'] ?? 0)
    //      + ($request['cl_1a5_ppnbm'] ?? 0)
    //      + ($data['cl_1a6_ppnbm'] ?? 0)
    //      + ($data['cl_1a7_ppnbm'] ?? 0)
    //      + ($data['cl_1a8_ppnbm'] ?? 0)
    //      + ($request['cl_1a9_ppnbm'] ?? 0);

    //     $data['cl_1c_dpp'] = $data['cl_1a_jumlah_dpp'] + ($data['cl_1b_dpp'] ?? 0);

    //     $data['cl_2g_dpp'] =
    //        ($data['cl_2a_dpp'] ?? 0)
    //      + ($data['cl_2b_dpp'] ?? 0)
    //      + ($data['cl_2c_dpp'] ?? 0)
    //      + ($data['cl_2d_dpp'] ?? 0);

    //      $data['cl_2g_ppn'] =
    //         ($data['cl_2a_ppn'] ?? 0)
    //      + ($data['cl_2b_ppn'] ?? 0)
    //      + ($data['cl_2c_ppn'] ?? 0)
    //      + ($data['cl_2d_ppn'] ?? 0);
    //      + ($request['cl_2e_ppn'] ?? 0);

    //      $data['cl_2j_dpp'] = ($data['cl_2g_dpp'] ?? 0 ) + ($request['cl_2h_dpp'] ?? 0 ) + ($request['cl_2i_dpp'] ?? 0 );

    //      $data['cl_3a_ppn'] = ($data['cl_1a2_ppn'] ?? 0) + ($data['cl_1a3_ppn'] ?? 0) + ($data['cl_1a4_ppn'] ?? 0) + ($request['cl_1a5_ppn'] ?? 0);
    //      $data['cl_3c_ppn'] = ($data['cl_2g_ppn'] ?? 0);
    //      $data['cl_3e_ppn'] = ($data['cl_3a_ppn'] ?? 0) - ($request['cl_3b_ppn'] ?? 0) - ($data['cl_3c_ppn'] ?? 0) - ($request['cl_3d_ppn'] ?? 0);
    //      $data['cl_3g_ppn'] = ($data['cl_3e_ppn'] ?? 0) - ($request['cl_3f_ppn'] ?? 0);

    //      if ($data['cl_3g_ppn'] < 0){
    //         $data['cl_3h_diminta_pengembalian'] = '0';
    //      }

    //      $cl_4_ppn_terutang_dpp = ($request['cl_4_ppn_terutang_dpp'] ?? 0);
    //      $data['cl_4_ppn_terutang'] = $cl_4_ppn_terutang_dpp * 0.12;

    //      $data['cl_6a_ppnbm'] = ($data['cl_1a2_ppnbm'] ?? 0) + ($data['cl_1a3_ppnbm'] ?? 0) + ($data['cl_1a4_ppnbm'] ?? 0) + ($request['cl_1a5_ppnbm'] ?? 0);
    //      $data['cl_6c_ppnbm'] = ($data['cl_6a_ppnbm'] ?? 0) - ($request['cl_6b_ppnbm'] ?? 0);
    //      $data['cl_6e_ppnbm'] = ($data['cl_6c_ppnbm'] ?? 0) - ($request['cl_6d_ppnbm'] ?? 0);
    //      $data['cl_6f_diminta_pengembalian'] = $data['cl_6e_ppnbm'] < 0;

    //      $data['cl_7c_dpp'] = ($request['cl_7a_dpp'] ?? 0) - ($request['cl_7b_dpp'] ?? 0);
    //      $data['cl_7c_ppn'] = ($request['cl_7a_ppn'] ?? 0) - ($request['cl_7b_ppn'] ?? 0);
    //      $data['cl_7c_ppnbm'] = ($request['cl_7a_ppnbm'] ?? 0) - ($request['cl_7b_ppnbm'] ?? 0);
    //      $data['cl_7c_dpp_lain'] = ($request['cl_7a_dpp_lain'] ?? 0) - ($request['cl_7b_dpp_lain'] ?? 0);

    //      $data['cl_8c_dpp'] = ($request['cl_8a_dpp'] ?? 0) - ($request['cl_8b_dpp'] ?? 0);
    //      $data['cl_8c_ppn'] = ($request['cl_8a_ppn'] ?? 0) - ($request['cl_8b_ppn'] ?? 0);
    //      $data['cl_8c_ppnbm'] = ($request['cl_8a_ppnbm'] ?? 0) - ($request['cl_8b_ppnbm'] ?? 0);
    //      $data['cl_8c_dpp_lain'] = ($request['cl_8a_dpp_lain'] ?? 0) - ($request['cl_8b_dpp_lain'] ?? 0);

    //     $data->save();
    //     //isi sendiri 1a5 1a9 1b 2e 2f 2h 2i 3b 3d 3f 4 5 6b 6d 7a 7b 8 8ba
    //     //calculate 1c 2g 2j 3g 3h 4 6a 6c 6f 7c 8c
    //     return $data;
    // }
    }
}