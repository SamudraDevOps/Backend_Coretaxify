<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\TempatKegiatanUsaha;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TempatKegiatanUsahaResource;
use App\Support\Interfaces\Services\TempatKegiatanUsahaServiceInterface;
use App\Http\Requests\TempatKegiatanUsaha\StoreTempatKegiatanUsahaRequest;
use App\Http\Requests\TempatKegiatanUsaha\UpdateTempatKegiatanUsahaRequest;

class ApiTempatKegiatanUsahaController extends ApiController {
    public function __construct(
        protected TempatKegiatanUsahaServiceInterface $tempatKegiatanUsahaService
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

        return TempatKegiatanUsahaResource::collection($this->tempatKegiatanUsahaService->getAllPaginated($filters, $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreTempatKegiatanUsahaRequest $request) {
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

        return $this->tempatKegiatanUsahaService->create($request->validated(),$sistem);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, TempatKegiatanUsaha $tempatKegiatanUsaha) {
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

        if ($tempatKegiatanUsaha->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses punyak siapa.');
        }

        return new TempatKegiatanUsahaResource($tempatKegiatanUsaha);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateTempatKegiatanUsahaRequest $request, TempatKegiatanUsaha $tempatKegiatanUsaha) {
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

        if ($tempatKegiatanUsaha->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses  punyak siapa.');
        }

        return $this->tempatKegiatanUsahaService->update($tempatKegiatanUsaha, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, TempatKegiatanUsaha $tempatKegiatanUsaha) {
        return $this->tempatKegiatanUsahaService->delete($tempatKegiatanUsaha);
    }
}
