<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\DetailBank\StoreDetailBankRequest;
use App\Http\Requests\DetailBank\UpdateDetailBankRequest;
use App\Http\Resources\DetailBankResource;
use App\Models\DetailBank;
use App\Support\Interfaces\Services\DetailBankServiceInterface;
use Illuminate\Http\Request;

class ApiDetailBankController extends ApiController {
    public function __construct(
        protected DetailBankServiceInterface $detailBankService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return DetailBankResource::collection($this->detailBankService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetailBankRequest $request) {
        return $this->detailBankService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailBank $detailBank) {
        return new DetailBankResource($detailBank);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetailBankRequest $request, DetailBank $detailBank) {
        return $this->detailBankService->update($detailBank, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DetailBank $detailBank) {
        return $this->detailBankService->delete($detailBank);
    }
}