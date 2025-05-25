<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
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
    public function index(Assignment $assignment, Sistem $sistem,Request $request) {
        $perPage = request()->get('perPage', 5);

        $this->pembayaranService->authorizeAccess($assignment, $sistem);

        $pembayarans = $this->pembayaranService->getAllForPembayaran($sistem, $perPage);

        return PembayaranResource::collection($pembayarans);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, Request $request) {
        $this->pembayaranService->authorizeAccess($assignment, $sistem);

        $randomNumber = mt_rand(100000000000000, 999999999999999);
        $request['kode_billing'] = $randomNumber;
        $request['sistem_id'] = $sistem->id;

        return $this->pembayaranService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem,Pembayaran $pembayaran) {
        $this->pembayaranService->authorizeAccess($assignment, $sistem);
        return new PembayaranResource($pembayaran);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, Request $request, Pembayaran $pembayaran) {
        $this->pembayaranService->authorizeAccess($assignment, $sistem);
        $pembayaran->is_paid = true;
        $pembayaran->save();

        $sistem->saldo = ($sistem->saldo ?? 0) + ($pembayaran->nilai ?? 0);
        $sistem->save();
        return $this->pembayaranService->update($pembayaran, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pembayaran $pembayaran) {
        return $this->pembayaranService->delete($pembayaran);
    }
}
