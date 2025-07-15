<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SelfAssignment;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\SelfAssignmentResource;
use App\Http\Requests\SelfAssignment\StoreSelfAssignmentRequest;
use App\Http\Requests\SelfAssignment\UpdateSelfAssignmentRequest;
use App\Support\Interfaces\Services\SelfAssignmentServiceInterface;

class ApiSelfAssignmentController extends ApiController
{
    public function __construct(
        protected SelfAssignmentServiceInterface $selfAssignmentService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = request()->get('perPage', 20);
        $intent = request()->get('intent');
        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_GET_SELF_ASSIGNMENT_ALL->value:
                return SelfAssignmentResource::collection($this->selfAssignmentService->getAllPaginated($request->query(), $perPage));
        }

        return SelfAssignmentResource::collection($this->selfAssignmentService->getSelfAssignmentsByUserId($user->id, $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSelfAssignmentRequest $request)
    {
        $intent = $request->get('intent');
        $user = auth()->user();

        if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
            return response()->json([
                'message' => 'Anda tidak diperbolehkan untuk membuat tugas sendiri.',
            ], 403);
        }

        return $this->selfAssignmentService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SelfAssignment $selfAssignment)
    {
        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_DOWNLOAD_FILE->value:
                return $this->selfAssignmentService->downloadFile($selfAssignment);
        }

        return new SelfAssignmentResource($selfAssignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSelfAssignmentRequest $request, SelfAssignment $selfAssignment)
    {
        return $this->selfAssignmentService->update($selfAssignment, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, SelfAssignment $selfAssignment)
    {
        return $this->selfAssignmentService->delete($selfAssignment);
    }
}
