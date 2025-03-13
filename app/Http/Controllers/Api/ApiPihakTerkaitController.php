<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PihakTerkait\StorePihakTerkaitRequest;
use App\Http\Requests\PihakTerkait\UpdatePihakTerkaitRequest;
use App\Http\Resources\PihakTerkaitResource;
use App\Models\PihakTerkait;
use App\Models\Assignment;
use App\Models\Sistem;
use App\Support\Enums\IntentEnum;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;
use Illuminate\Http\Request;

class ApiPihakTerkaitController extends ApiController {
    public function __construct(
        protected PihakTerkaitServiceInterface $pihakTerkaitService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return PihakTerkaitResource::collection($this->pihakTerkaitService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StorePihakTerkaitRequest $request) {
        // dd($request->all());
        $validated = $request->validated();
        $validated['intent'] = $request->get('intent');

        switch ($validated['intent']) {
            case IntentEnum::API_CREATE_PIHAK_TERKAIT->value:
                return $this->pihakTerkaitService->create($validated,$sistem);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(PihakTerkait $pihakTerkait) {
        return new PihakTerkaitResource($pihakTerkait);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePihakTerkaitRequest $request, PihakTerkait $pihakTerkait) {
        return $this->pihakTerkaitService->update($pihakTerkait, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PihakTerkait $pihakTerkait) {
        return $this->pihakTerkaitService->delete($pihakTerkait);
    }
}
