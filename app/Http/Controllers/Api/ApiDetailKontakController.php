<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DetailKontak\StoreDetailKontakRequest;
use App\Http\Requests\DetailKontak\UpdateDetailKontakRequest;
use App\Http\Resources\DetailKontakResource;
use App\Models\Assignment;
use App\Models\DetailKontak;
use App\Models\Sistem;
use App\Support\Interfaces\Services\DetailKontakServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiDetailKontakController extends ApiController
{
    /**
     * Create a new controller instance.
     *
     * @param DetailKontakServiceInterface $detailKontakService
     */
    public function __construct(
        protected DetailKontakServiceInterface $detailKontakService
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
        $perPage = $request->get('perPage', 20);

        $detailKontaks = $this->detailKontakService->getAllForSistem(
            $assignment,
            $sistem,
            $request,
            $perPage
        );

        return DetailKontakResource::collection($detailKontaks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param StoreDetailKontakRequest $request
     * @return DetailKontakResource
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreDetailKontakRequest $request): DetailKontakResource
    {
        // Authorize access to the sistem first
        $this->detailKontakService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $detailKontak = $this->detailKontakService->create($request->validated(), $sistem);

        return new DetailKontakResource($detailKontak);
    }

    /**
     * Display the specified resource.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return DetailKontakResource
     */
    public function show(Assignment $assignment, Sistem $sistem, DetailKontak $detailKontak, Request $request): DetailKontakResource
    {
        $detailKontak = $this->detailKontakService->getDetailKontakDetail(
            $assignment,
            $sistem,
            $detailKontak,
            $request
        );

        return new DetailKontakResource($detailKontak);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UpdateDetailKontakRequest $request
     * @param DetailKontak $detailKontak
     * @return DetailKontakResource
     */
    public function update(
        Assignment $assignment,
        Sistem $sistem,
        UpdateDetailKontakRequest $request,
        DetailKontak $detailKontak
    ): DetailKontakResource {
        $detailKontak = $this->detailKontakService->updateDetailKontak(
            $assignment,
            $sistem,
            $detailKontak,
            $request->validated(),
            $request
        );

        return new DetailKontakResource($detailKontak);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return JsonResponse
     */
    public function destroy(Assignment $assignment, Sistem $sistem, DetailKontak $detailKontak, Request $request): JsonResponse
    {
        $result = $this->detailKontakService->deleteDetailKontak(
            $assignment,
            $sistem,
            $detailKontak,
            $request
        );

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Detail kontak deleted successfully' : 'Failed to delete detail kontak'
        ]);
    }

    /**
     * Get detail kontak by jenis kontak.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getByJenisKontak(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        // Authorize access to the sistem first
        $this->detailKontakService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $jenisKontak = $request->get('jenis_kontak');
        $detailKontaks = $this->detailKontakService->getByJenisKontak($jenisKontak, $sistem->id);

        return DetailKontakResource::collection($detailKontaks);
    }

    /**
     * Get detail kontak by email.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getByEmail(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        // Authorize access to the sistem first
        $this->detailKontakService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $email = $request->get('email');
        $detailKontaks = $this->detailKontakService->getByEmail($email, $sistem->id);

        return DetailKontakResource::collection($detailKontaks);
    }

    /**
     * Get detail kontak by phone number.
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getByPhoneNumber(Assignment $assignment, Sistem $sistem, Request $request): AnonymousResourceCollection
    {
        // Authorize access to the sistem first
        $this->detailKontakService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $phoneNumber = $request->get('phone');
        $detailKontaks = $this->detailKontakService->getByPhoneNumber($phoneNumber, $sistem->id);

        return DetailKontakResource::collection($detailKontaks);
    }
}
