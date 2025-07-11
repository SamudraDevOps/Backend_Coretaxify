<?php

namespace App\Http\Controllers\Api;

use App\Support\Enums\JenisPajakEnum;
use Carbon\Carbon;
use App\Models\KapKjs;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\Pembayaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Support\Enums\SptStatusEnum;
use App\Http\Resources\PembayaranResource;
use App\Http\Requests\Pembayaran\StorePembayaranRequest;
use App\Http\Requests\Pembayaran\UpdatePembayaranRequest;
use App\Support\Interfaces\Services\PembayaranServiceInterface;

class ApiPembayaranController extends ApiController {
    public function __construct(
        protected PembayaranServiceInterface $pembayaranService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = request()->get('perPage', 20);

        $this->pembayaranService->authorizeAccess($assignment, $sistem, $request);

        if($request['intent'] == IntentEnum::API_GET_SUDAH_PEMBAYARAN->value){
            $pembayarans = $this->pembayaranService->getAllForSudahPembayaran($sistem, $perPage);
        } else {
            $pembayarans = $this->pembayaranService->getAllForPembayaran($sistem, $perPage);
        }

        // Jika paginator
        $total_nilai = $pembayarans->getCollection()->sum('nilai');
        // Jika collection biasa, pakai: $total_nilai = $pembayarans->sum('nilai');

        return PembayaranResource::collection($pembayarans)
            ->additional([
                'meta' => [
                    'total_nilai' => $total_nilai
                ]
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->pembayaranService->authorizeAccess($assignment, $sistem, $request);

        $randomNumber = mt_rand(100000000000000, 999999999999999);
        $ntpn = Str::random(16);

        $checkDate = $request['masa_bulan'];

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
            $masa_bulan = $request['masa_bulan'];
            $masa_tahun = $request['masa_tahun'];
            $bulanAngka = $bulanMap[$masa_bulan] ?? '00';
            $masa_pajak = $bulanAngka . $masa_tahun;
        } else {
            $masa_bulan = $request['masa_bulan'];
            $masa_tahun = $request['masa_tahun'];
            $masa_pajak = '0112'. $masa_tahun;
        }
        $sistem = Sistem::where('id', $sistem->id)->first();
        // $kapKjs = KapKjs::where('id', $request['kap_kjs_id'])->first();
        $request['ntpn'] = $ntpn;
        $request['kode_billing'] = $randomNumber;
        $request['badan_id'] = $sistem->id;
        $request['masa_pajak'] = $masa_pajak;
        $request['masa_bulan'] = $masa_bulan;
        $request['masa_tahun'] = $masa_tahun;
        $request['masa_aktif'] = Carbon::now() -> addWeek();

        return $this->pembayaranService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, Pembayaran $pembayaran, Request $request) {
        $this->pembayaranService->authorizeAccess($assignment, $sistem, $request);

        $additionalData = [];

        if ($pembayaran->spt && ($pembayaran->spt->jenis_pajak == JenisPajakEnum::PPH->value || $pembayaran->spt->jenis_pajak == JenisPajakEnum::PPH_UNIFIKASI->value)) {
            $additionalData['show'] = true;
        }

        return (new PembayaranResource($pembayaran))->additional($additionalData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, Request $request, Pembayaran $pembayaran) {
        $this->pembayaranService->authorizeAccess($assignment, $sistem, $request);
        $pembayaran->is_paid = true;
        $pembayaran->save();

        $ntpn = Str::random(16);

        if ($pembayaran->kap_kjs_id == 42) {
            $sistem->saldo = ($sistem->saldo) + ($pembayaran->nilai);
            $sistem->save();
        }else if ($pembayaran->spt) {
            $pembayaran->spt->status = SptStatusEnum::DILAPORKAN->value;
            $pembayaran->spt->save();
        }else{
            $pembayaran->ntpn = $ntpn;
            $pembayaran->save();
        }
        return $this->pembayaranService->update($pembayaran, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pembayaran $pembayaran) {
        return $this->pembayaranService->delete($pembayaran);
    }
}
