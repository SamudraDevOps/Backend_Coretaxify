<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetailBank\StoreDetailBankRequest;
use App\Http\Requests\DetailBank\UpdateDetailBankRequest;
use App\Http\Resources\DetailBankResource;
use App\Models\Assignment;
use App\Models\DetailBank;
use App\Models\Sistem;
use App\Support\Interfaces\Services\DetailBankServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiDetailBankController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @param DetailBankServiceInterface $detailBankService
     */
    public function __construct(
        protected DetailBankServiceInterface $detailBankService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', 5);

        $detailBanks = $this->detailBankService->getAllForSistem(
            $assignment,
            $sistem,
            $request,
            $perPage
        );

        return DetailBankResource::collection($detailBanks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param StoreDetailBankRequest $request
     * @return DetailBankResource
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreDetailBankRequest $request): DetailBankResource
    {
        // Authorize access to the sistem first
        $this->detailBankService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $detailBank = $this->detailBankService->create($request->validated(), $sistem);

        return new DetailBankResource($detailBank);
    }

    /**
     * Display the specified resource.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return DetailBankResource
     */
    public function show(Assignment $assignment, Sistem $sistem, DetailBank $detailBank): DetailBankResource
    {
        $detailBank = $this->detailBankService->getDetailBankDetail(
            $assignment,
            $sistem,
            $detailBank
        );

        return new DetailBankResource($detailBank);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UpdateDetailBankRequest $request
     * @param DetailBank $detailBank
     * @return DetailBankResource
     */
    public function update(
        Assignment $assignment,
        Sistem $sistem,
        UpdateDetailBankRequest $request,
        DetailBank $detailBank
    ): DetailBankResource {
        $detailBank = $this->detailBankService->updateDetailBank(
            $assignment,
            $sistem,
            $detailBank,
            $request->validated()
        );

        return new DetailBankResource($detailBank);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return JsonResponse
     */
    public function destroy(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank
    ): JsonResponse {
        $result = $this->detailBankService->deleteDetailBank(
            $assignment,
            $sistem,
            $detailBank
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Detail bank deleted successfully' : 'Failed to delete detail bank'
        ]);
    }

    /**
     * Get detail bank by nama bank.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getByNamaBank(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        // Authorize access to the sistem first
        $this->detailBankService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $namaBank = $request->get('nama_bank');
        $detailBanks = $this->detailBankService->getByNamaBank($namaBank, $sistem->id);

        return DetailBankResource::collection($detailBanks);
    }

    /**
     * Get detail bank by nomor rekening.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getByNomorRekening(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        // Authorize access to the sistem first
        $this->detailBankService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $nomorRekening = $request->get('nomor_rekening');
        $detailBanks = $this->detailBankService->getByNomorRekening($nomorRekening, $sistem->id);

        return DetailBankResource::collection($detailBanks);
    }

    /**
     * Get detail bank by jenis rekening.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getByJenisRekening(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        // Authorize access to the sistem first
        $this->detailBankService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $jenisRekening = $request->get('jenis_rekening');
        $detailBanks = $this->detailBankService->getByJenisRekening($jenisRekening, $sistem->id);

        return DetailBankResource::collection($detailBanks);
    }
}
