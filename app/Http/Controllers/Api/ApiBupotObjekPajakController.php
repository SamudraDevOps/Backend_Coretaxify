<?php

namespace App\Http\Controllers\Api;

use App\Support\Enums\BupotTypeEnum;
use Illuminate\Http\Request;
use App\Models\BupotObjekPajak;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\BupotObjekPajakResource;
use App\Http\Requests\BupotObjekPajak\StoreBupotObjekPajakRequest;
use App\Http\Requests\BupotObjekPajak\UpdateBupotObjekPajakRequest;
use App\Support\Interfaces\Services\BupotObjekPajakServiceInterface;

class ApiBupotObjekPajakController extends ApiController
{
    public function __construct(
        protected BupotObjekPajakServiceInterface $bupotObjekPajakService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = request()->get('perPage', 5);
        $intent = request()->get('intent');

        switch ($intent) {
            case IntentEnum::API_BUPOT_BPPU->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPPU->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPNR->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPNR->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_PS->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::PS->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_PSD->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::PSD->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BP21->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BP21->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BP26->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BP26->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPA1->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPA1->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPA2->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPA2->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPBPT->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPBPT->value;
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            // case IntentEnum::API_BUPOT_DSBP->value:
            //     $filters = $request->query();
            //     $filters['tipe_bupot'] = BupotTypeEnum::DSBP->value;
            //     return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($filters, $perPage));

            default:
                return BupotObjekPajakResource::collection($this->bupotObjekPajakService->getAllPaginated($request->query(), $perPage));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotObjekPajakRequest $request)
    {
        return $this->bupotObjekPajakService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(BupotObjekPajak $bupotObjekPajak)
    {
        return new BupotObjekPajakResource($bupotObjekPajak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotObjekPajakRequest $request, BupotObjekPajak $bupotObjekPajak)
    {
        return $this->bupotObjekPajakService->update($bupotObjekPajak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BupotObjekPajak $bupotObjekPajak)
    {
        return $this->bupotObjekPajakService->delete($bupotObjekPajak);
    }
}
