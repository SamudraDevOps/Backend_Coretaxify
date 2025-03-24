<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\PihakTerkait;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
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


        return PihakTerkaitResource::collection($this->pihakTerkaitService->getAllBySistemId($request->query(), $sistem->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StorePihakTerkaitRequest $request) {
        // dd($request->all());
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

        return $this->pihakTerkaitService->create($request->validated(),$sistem);
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
