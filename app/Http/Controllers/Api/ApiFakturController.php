<?php

namespace App\Http\Controllers\Api;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\SistemTambahan;
use App\Models\DetailTransaksi;
use App\Http\Resources\FakturResource;
use App\Http\Requests\Faktur\StoreFakturRequest;
use App\Http\Requests\Faktur\UpdateFakturRequest;
use App\Support\Interfaces\Services\FakturServiceInterface;
use App\Http\Requests\DetailTransaksi\StoreDetailTransaksiRequest;

class ApiFakturController extends ApiController {
    public function __construct(
        protected FakturServiceInterface $fakturService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = request()->get('perPage', 5);

        $fakturs = $this->fakturService->getAllForSistem(
            $assignment,
            $sistem,
            $request,
            $perPage
        );

        return FakturResource::collection($fakturs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreFakturRequest $request) {
        $this->fakturService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $data = $request->validated();
        $data['intent'] = $request->input('intent', null); // Get intent from request or use null

        $faktur = $this->fakturService->create($data, $sistem);

        return new FakturResource($faktur);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, Faktur $faktur) {
        $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);


        $faktur->load('detail_transaksis');
        return new FakturResource($faktur);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateFakturRequest $request, Faktur $faktur) {
        $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);

        $updatedFaktur = $this->fakturService->update($faktur, $request->validated());
        $updatedFaktur->load('detail_transaksis');

        return new FakturResource($updatedFaktur);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment, Sistem $sistem, Request $request, Faktur $faktur)
    {
        // Ensure the faktur belongs to the sistem
        $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);

        $draft = $faktur->is_draft;

        if ($draft) {
            return response()->json([
                'message' => 'Faktur masih dalam draft'
            ], 400);
        }

        return $this->fakturService->delete($faktur);
    }

    public function deleteDetailTransaksi(Faktur $faktur, $detailTransaksiId)
    {
        $detailTransaksi = DetailTransaksi::where('faktur_id', $faktur->id)
            ->where('id', $detailTransaksiId)
            ->firstOrFail();

        $this->fakturService->deleteDetailTransaksi($detailTransaksi);

        return response()->json([
            'message' => 'Detail transaksi deleted successfully'
        ]);
    }

    public function addDetailTransaksi(Faktur $faktur, StoreDetailTransaksiRequest $request)
    {

        $detailTransaksi = $this->fakturService->addDetailTransaksi($faktur, $request->validated());

        return response()->json([
            'message' => 'Detail transaksi added successfully',
            'data' => $detailTransaksi
        ], 201);
    }

    public function getCombinedAkunData(Assignment $assignment, Sistem $sistem)
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
            ])->firstOrFail();

        $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)->get()->map(function ($item) {
            $item->is_akun_tambahan = false;
            return $item;
        });

        $sistemTambahans = SistemTambahan::where('sistem_id', $sistem->id)->get()->map(function ($item) {
            $item->is_akun_tambahan = true;
            return $item;
        });

        return $sistems->concat($sistemTambahans);
    }
}
