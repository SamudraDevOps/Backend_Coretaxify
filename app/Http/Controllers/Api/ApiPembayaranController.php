<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Pembayaran\StorePembayaranRequest;
use App\Http\Requests\Pembayaran\UpdatePembayaranRequest;
use App\Http\Resources\PembayaranResource;
use App\Models\Pembayaran;
use App\Support\Interfaces\Services\PembayaranServiceInterface;
use Illuminate\Http\Request;

class ApiPembayaranController extends ApiController {
    public function __construct(
        protected PembayaranServiceInterface $pembayaranService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return PembayaranResource::collection($this->pembayaranService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembayaranRequest $request) {
        return $this->pembayaranService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran) {
        return new PembayaranResource($pembayaran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran) {
        return $this->pembayaranService->update($pembayaran, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pembayaran $pembayaran) {
        return $this->pembayaranService->delete($pembayaran);
    }
}