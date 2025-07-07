<?php

namespace App\Http\Controllers\Api;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Support\Enums\IntentEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DetailTransaksiResource;
use App\Http\Requests\DetailTransaksi\StoreDetailTransaksiRequest;
use App\Http\Requests\DetailTransaksi\UpdateDetailTransaksiRequest;
use App\Support\Interfaces\Services\DetailTransaksiServiceInterface;

class ApiDetailTransaksiController extends ApiController {
    public function __construct(
        protected DetailTransaksiServiceInterface $detailTransaksiService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return DetailTransaksiResource::collection($this->detailTransaksiService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, Faktur $faktur, Request $request) {
        // $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $request['faktur_id'] = $faktur->id;

        if (!$faktur->is_draft){
            $request['is_tambahan'] = true;
        }
        return $this->detailTransaksiService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, Faktur $faktur, DetailTransaksi $detailTransaksi) {
        // $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $this->detailTransaksiService->authorizeDetailTraBelongsToFaktur($faktur, $detailTransaksi);

        return new DetailTransaksiResource($detailTransaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, Faktur $faktur, Request $request, DetailTransaksi $detailTransaksi) {
        // $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $this->detailTransaksiService->authorizeDetailTraBelongsToFaktur($faktur, $detailTransaksi);
        $request['faktur_id'] = $faktur->id;

        if ($request['intent'] && $request['intent'] == IntentEnum::API_UPDATE_DETAIL_TRANSAKSI_FAKTUR_RETUR_MASUKAN->value) {
            $request['total_harga_diretur'] = ($request['jumlah_barang_diretur'] ?? 0) * $detailTransaksi->harga_satuan;
            return $this->detailTransaksiService->update($detailTransaksi, $request->all());
        }else {
            if (!$faktur->is_draft) {
                if (!$detailTransaksi->is_lama){
                    $this->moveCurrentDataToLamaColumns($detailTransaksi, $request->all());
                }
            }
        }

        return $this->detailTransaksiService->update($detailTransaksi, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment, Sistem $sistem, Faktur $faktur, DetailTransaksi $detailTransaksi) {
        // $this->detailTransaksiService->authorizeAccess($assignment, $sistem, $faktur);
        $this->detailTransaksiService->authorizeDetailTraBelongsToFaktur($faktur, $detailTransaksi);

        if ($faktur->is_draft || $detailTransaksi->is_tambahan) {
            return DetailTransaksi::where('id', $detailTransaksi->id)->forceDelete();
        } else {
            return $this->detailTransaksiService->softDelete($detailTransaksi);
        }

    }

    private function moveCurrentDataToLamaColumns(DetailTransaksi $detailTransaksi, array $newData): void
    {
        // Mapping kolom normal ke kolom _lama
        $columnMapping = [
            'tipe' => 'tipe_lama',
            'nama' => 'nama_lama',
            'kode' => 'kode_lama',
            'kuantitas' => 'kuantitas_lama',
            'satuan' => 'satuan_lama',
            'harga_satuan' => 'harga_satuan_lama',
            'total_harga' => 'total_harga_lama',
            'pemotongan_harga' => 'pemotongan_harga_lama',
            'dpp' => 'dpp_lama',
            'ppn' => 'ppn_lama',
            'dpp_lain' => 'dpp_lain_lama',
            'ppnbm' => 'ppnbm_lama',
            'ppn_retur' => 'ppn_retur_lama',
            'dpp_lain_retur' => 'dpp_lain_retur_lama',
            'ppnbm_retur' => 'ppnbm_retur_lama',
            'tarif_ppnbm' => 'tarif_ppnbm_lama',
        ];

        $dataToUpdate = [];

        $dataToUpdate['is_lama'] = true;

        // Pindahkan data current ke kolom _lama hanya untuk field yang akan diupdate
        foreach ($columnMapping as $normalColumn => $lamaColumn) {
            // Hanya pindahkan jika ada data baru untuk kolom tersebut
            if (array_key_exists($normalColumn, $newData)) {
                // Pindahkan nilai current ke kolom _lama
                $dataToUpdate[$lamaColumn] = $detailTransaksi->$normalColumn;
            }
        }

        // Update detail transaksi dengan data lama
        if (!empty($dataToUpdate)) {
            $detailTransaksi->update($dataToUpdate);
        }
    }
}
