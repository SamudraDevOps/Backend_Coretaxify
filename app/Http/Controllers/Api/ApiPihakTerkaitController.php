<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\PihakTerkait;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\PihakTerkaitResource;
use App\Http\Requests\PihakTerkait\StorePihakTerkaitRequest;
use App\Http\Requests\PihakTerkait\UpdatePihakTerkaitRequest;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;

class ApiPihakTerkaitController extends ApiController {
    public function __construct(
        protected PihakTerkaitServiceInterface $pihakTerkaitService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = $request->get('perPage', 20);

        // Authorize access to the sistem first
        $this->pihakTerkaitService->getAllForSistem($assignment, $sistem, new Request(), 1);

        // Get pihak terkait data
        $pihakTerkaits = $this->pihakTerkaitService->getAllBySistemId($request->query(), $sistem->id);

        return PihakTerkaitResource::collection($pihakTerkaits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StorePihakTerkaitRequest $request) {
        $this->pihakTerkaitService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $pihakTerkait = $this->pihakTerkaitService->create($request->validated(), $sistem);

        return new PihakTerkaitResource($pihakTerkait);
    }

    public function destroy(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait
        ): JsonResponse {
            $result = $this->pihakTerkaitService->deletePihakTerkait(
                $assignment,
                $sistem,
                $pihakTerkait
            );
        return response()->json([
            'success' => $result,
            'message' => $result ? 'Pihak terkait deleted successfully' : 'Failed to delete pihak terkait'
        ]);
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
}
