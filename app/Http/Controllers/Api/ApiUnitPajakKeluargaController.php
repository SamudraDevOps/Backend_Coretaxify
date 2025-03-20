<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\UnitPajakKeluarga;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UnitPajakKeluargaResource;
use App\Http\Requests\UnitPajakKeluarga\StoreUnitPajakKeluargaRequest;
use App\Support\Interfaces\Services\UnitPajakKeluargaServiceInterface;
use App\Http\Requests\UnitPajakKeluarga\UpdateUnitPajakKeluargaRequest;

class ApiUnitPajakKeluargaController extends ApiController {
    public function __construct(
        protected UnitPajakKeluargaServiceInterface $unitPajakKeluargaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = request()->get('perPage', 5);

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



        $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);

        return UnitPajakKeluargaResource::collection($this->unitPajakKeluargaService->getAllPaginated($filters, $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreUnitPajakKeluargaRequest $request) {
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

        // dd($request->validated());
        return $this->unitPajakKeluargaService->create($request->validated(), $sistem);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, UnitPajakKeluarga $unitPajakKeluarga) {
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

        if ($unitPajakKeluarga->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses punyak siapa.');
        }

        return new UnitPajakKeluargaResource($unitPajakKeluarga);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateUnitPajakKeluargaRequest $request, UnitPajakKeluarga $unitPajakKeluarga) {
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

        if ($unitPajakKeluarga->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses detail kontak punyak siapa.');
        }

        return $this->unitPajakKeluargaService->update($unitPajakKeluarga, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, UnitPajakKeluarga $unitPajakKeluarga) {
        return $this->unitPajakKeluargaService->delete($unitPajakKeluarga);
    }
}
