<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\UserResource;
use App\Http\Resources\AssignmentResource;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Support\Interfaces\Services\AssignmentServiceInterface;

class ApiAssignmentController extends ApiController
{
    public function __construct(
        protected AssignmentServiceInterface $assignmentService
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
            case IntentEnum::API_GET_ASSIGNMENT_ALL->value:
                return AssignmentResource::collection($this->assignmentService->getAllPaginated($request->query(), $perPage)->load(['group']));
        }

        $assignments = $this->assignmentService->getAssignmentsByUserId($user->id, $perPage);

        // $assignments->load(['user', 'group']);

        // return $assignments;
        return AssignmentResource::collection($assignments);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssignmentRequest $request)
    {
        $intent = $request->get('intent');
        // dd($request->all());
        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_ASSIGNMENT->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('instruktur') || $user->hasRole('admin')) {
                    return $this->assignmentService->create($request->validated());
                } else {
                    return response()->json([
                        'message' => 'Anda tidak memiliki izin untuk membuat tugas / praktikum.',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_ASSIGNMENT->value:
                if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
                    try {
                        $result = $this->assignmentService->joinAssignment($request->validated());
                        return response()->json([
                            'message' => 'Anda berhasil bergabung dengan tugas / praktikum.',
                            'data' => $result,
                        ], 200);
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => $e->getMessage(),
                        ], 403);

                    }
                } else {
                    return response()->json([
                        'message' => 'Anda tidak memiliki izin untuk bergabung dengan tugas / praktikum.',
                    ], 403);
                }
            case IntentEnum::API_USER_CREATE_EXAM->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('admin')) {
                    return $this->assignmentService->createExam($request->validated());
                } else {
                    return response()->json([
                        'message' => 'Anda tidak memiliki izin untuk membuat ujian',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_EXAM->value:
                if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
                    try {
                        $result = $this->assignmentService->joinExam($request->validated());
                        return response()->json([
                            'message' => 'Anda berhasil bergabung dengan ujian.',
                            'data' => $result,
                        ], 200);
                    } catch (\Exception $e) {
                        return response()->json([
                            'message' => $e->getMessage(),
                        ], 403);
                    }
                } else {
                    return response()->json([
                        'message' => 'Anda tidak memiliki izin untuk bergabung dengan ujian.',
                    ], 403);
                }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Assignment $assignment)
    {
        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_DOWNLOAD_FILE->value:
                return $this->assignmentService->downloadFile($assignment);
        }
        return new AssignmentResource($assignment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        return $this->assignmentService->update($assignment, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Assignment $assignment)
    {
        return $this->assignmentService->delete($assignment);
    }
    public function getMembers(Request $request, Assignment $assignment)
    {
        $perPage = $request->get('perPage', 20);

        $users = $assignment->users()
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['mahasiswa', 'mahasiswa-psc']);
            })
            ->withPivot('score') // Add this to include pivot data
            ->paginate($perPage);

        return UserResource::collection($users);
    }

    public function removeMember(Assignment $assignment, User $user)
    {
        $assignment->users()->detach($user->id);
        return response()->json(['message' => 'Member removed successfully']);
    }

    public function getMemberDetail(Assignment $assignment, User $user)
    {
        return $assignment->users()->findOrFail($user->id);
    }

    public function scoreMember(Request $request, Assignment $assignment, User $user)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100'
        ]);

        $assignmentUser = $assignment->users()->wherePivot('user_id', $user->id)->first();

        if (!$assignmentUser) {
            return response()->json(['message' => 'User is not a member of this assignment'], 404);
        }

        // Update the score in the pivot table
        $assignment->users()->updateExistingPivot($user->id, [
            'score' => $request->score
        ]);

        return response()->json([
            'message' => 'Score updated successfully',
            'score' => $request->score
        ]);
    }

    /**
     * Public download endpoint that uses signed URLs for security
     */
    public function downloadPublic(Request $request, Assignment $assignment)
    {
        // The 'signed' middleware has already verified the URL signature
        return $this->assignmentService->downloadFile($assignment);
    }
}
