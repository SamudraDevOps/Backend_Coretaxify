<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\JenisPajak\StoreJenisPajakRequest;
use App\Http\Requests\JenisPajak\UpdateJenisPajakRequest;
use App\Http\Resources\JenisPajakResource;
use App\Models\JenisPajak;
use App\Support\Interfaces\Services\JenisPajakServiceInterface;
use Illuminate\Http\Request;

class ApiJenisPajakController extends ApiController {
    public function __construct(
        protected JenisPajakServiceInterface $jenisPajakService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return JenisPajakResource::collection($this->jenisPajakService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJenisPajakRequest $request) {
        return $this->jenisPajakService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisPajak $jenisPajak) {
        return new JenisPajakResource($jenisPajak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJenisPajakRequest $request, JenisPajak $jenisPajak) {
        return $this->jenisPajakService->update($jenisPajak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, JenisPajak $jenisPajak) {
        return $this->jenisPajakService->delete($jenisPajak);
    }
}