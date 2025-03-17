<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\DetailKontak;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DetailKontakResource;
use App\Http\Requests\DetailKontak\StoreDetailKontakRequest;
use App\Http\Requests\DetailKontak\UpdateDetailKontakRequest;
use App\Support\Interfaces\Services\DetailKontakServiceInterface;

class ApiDetailKontakController extends ApiController {
    public function __construct(
        protected DetailKontakServiceInterface $detailKontakService
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

        return DetailKontakResource::collection($this->detailKontakService->getAllPaginated($filters, $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreDetailKontakRequest $request) {
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

        return $this->detailKontakService->create($request->validated(), $sistem);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, DetailKontak $detailKontak) {
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

        if ($detailKontak->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses detail kontak punyak siapa.');
        }

        return new DetailKontakResource($detailKontak);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem,UpdateDetailKontakRequest $request, DetailKontak $detailKontak) {
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

        if ($detailKontak->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses detail kontak punyak siapa.');
        }


        return $this->detailKontakService->update($detailKontak, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DetailKontak $detailKontak) {
        return $this->detailKontakService->delete($detailKontak);
    }
}
