<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\NomorIdentifikasiEksternal;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\NomorIdentifikasiEksternalResource;
use App\Support\Interfaces\Services\NomorIdentifikasiEksternalServiceInterface;
use App\Http\Requests\NomorIdentifikasiEksternal\StoreNomorIdentifikasiEksternalRequest;
use App\Http\Requests\NomorIdentifikasiEksternal\UpdateNomorIdentifikasiEksternalRequest;

class ApiNomorIdentifikasiEksternalController extends ApiController {
    public function __construct(
        protected NomorIdentifikasiEksternalServiceInterface $nomorIdentifikasiEksternalService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return NomorIdentifikasiEksternalResource::collection($this->nomorIdentifikasiEksternalService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNomorIdentifikasiEksternalRequest $request) {
        return $this->nomorIdentifikasiEksternalService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        return new NomorIdentifikasiEksternalResource($nomorIdentifikasiEksternal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateNomorIdentifikasiEksternalRequest $request, NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403);
        }

        Sistem::where('assignment_user_id', $assignmentUser->id)
                ->where('id', $sistem->id)
                ->firstOrFail();

        if ($nomorIdentifikasiEksternal->id !== $sistem->id) {
        abort(403, 'hayo ngakses detail kontak punyak siapa.');
        }

        return $this->nomorIdentifikasiEksternalService->update($nomorIdentifikasiEksternal, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, NomorIdentifikasiEksternal $nomorIdentifikasiEksternal) {
        return $this->nomorIdentifikasiEksternalService->delete($nomorIdentifikasiEksternal);
    }
}
