<?php

namespace App\Http\Controllers\Api;

use App\Models\Bupot;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Support\Enums\BupotTypeEnum;
use App\Http\Resources\BupotResource;
use App\Http\Requests\Bupot\StoreBupotRequest;
use App\Http\Requests\Bupot\UpdateBupotRequest;
use App\Support\Interfaces\Services\BupotServiceInterface;

class ApiBupotController extends ApiController {
    public function __construct(
        protected BupotServiceInterface $bupotService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);
        $intent = request()->get('intent');

        switch ($intent) {
            case IntentEnum::API_BUPOT_BPPU->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPPU->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPNR->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPNR->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_PS->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::PS->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_PSD->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::PSD->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BP21->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BP21->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BP26->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BP26->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPA1->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPA1->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPA2->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPA2->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            case IntentEnum::API_BUPOT_BPBPT->value:
                $filters = $request->query();
                $filters['tipe_bupot'] = BupotTypeEnum::BPBPT->value;
                return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            // case IntentEnum::API_BUPOT_DSBP->value:
            //     $filters = $request->query();
            //     $filters['tipe_bupot'] = BupotTypeEnum::DSBP->value;
            //     return BupotResource::collection($this->bupotService->getAllPaginated($filters, $perPage));

            default:
                return BupotResource::collection($this->bupotService->getAllPaginated($request->query(), $perPage));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBupotRequest $request) {
        return $this->bupotService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Bupot $bupot) {
        return new BupotResource($bupot);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBupotRequest $request, Bupot $bupot) {
        return $this->bupotService->update($bupot, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Bupot $bupot) {
        return $this->bupotService->delete($bupot);
    }
}
