<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AssignmentUser;
use App\Models\User;
use App\Services\AssignmentSharingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiSharingController extends Controller
{
    protected $sharingService;

    public function __construct(AssignmentSharingService $sharingService)
    {
        $this->sharingService = $sharingService;
    }

    public function shareAssignment(Request $request, AssignmentUser $assignmentUser): JsonResponse
    {
        $request->validate([
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'share_type' => 'required|in:admin_to_dosen,psc_to_instructor'
        ]);

        // Check permissions
        $user = auth()->user();
        if ($request->share_type === 'admin_to_dosen' && !$user->hasRole('admin')) {
            return response()->json(['error' => 'Only admin can share to dosen'], 403);
        }

        if ($request->share_type === 'psc_to_instructor' && !$user->hasRole('psc')) {
            return response()->json(['error' => 'Only PSC can share to instructor'], 403);
        }

        // Check if user owns this assignment
        if ($assignmentUser->user_id !== $user->id) {
            return response()->json(['error' => 'You can only share your own assignments'], 403);
        }

        // Validate target users have correct roles
        $targetUsers = User::whereIn('id', $request->user_ids)->with('roles')->get();

        foreach ($targetUsers as $targetUser) {
            if ($request->share_type === 'admin_to_dosen' && !$targetUser->hasRole('dosen')) {
                return response()->json(['error' => "User {$targetUser->name} is not a dosen"], 400);
            }

            if ($request->share_type === 'psc_to_instructor' && !$targetUser->hasRole('instruktur')) {
                return response()->json(['error' => "User {$targetUser->name} is not an instructor"], 400);
            }
        }

        try {
            $sharedResults = $this->sharingService->shareAssignmentUser(
                $assignmentUser,
                $request->user_ids,
                $request->share_type
            );

            return response()->json([
                'message' => 'Assignment shared successfully',
                'shared_count' => count($sharedResults),
                'shared_to' => $targetUsers->pluck('name')->toArray(),
                'results' => $sharedResults
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to share assignment',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getSharedAssignments(Request $request): JsonResponse
    {
        $user = auth()->user();
        $shareType = $request->get('share_type');

        $sharedAssignments = $this->sharingService->getSharedAssignments($user, $shareType);

        return response()->json([
            'data' => $sharedAssignments,
            'count' => $sharedAssignments->count()
        ]);
    }

    public function getAvailableUsers(Request $request): JsonResponse
    {
        $shareType = $request->get('share_type');
        $user = auth()->user();

        // Check permissions
        if ($shareType === 'admin_to_dosen' && !$user->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($shareType === 'psc_to_instructor' && !$user->hasRole('psc')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $query = User::query();

        if ($shareType === 'admin_to_dosen') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'dosen');
            });
        } elseif ($shareType === 'psc_to_instructor') {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'instruktur');
            });
        }

        $users = $query->select('id', 'name', 'email')->get();

        return response()->json([
            'data' => $users,
            'count' => $users->count()
        ]);
    }

    public function getMyAssignments(Request $request): JsonResponse
    {
        $user = auth()->user();

        // Only admin and psc can share their assignments
        if (!$user->hasRole('admin') && !$user->hasRole('psc')) {
            return response()->json(['error' => 'Only admin and PSC can share assignments'], 403);
        }

        $assignmentUsers = AssignmentUser::where('user_id', $user->id)
            ->where('is_start', true) // Only completed/started assignments can be shared
            ->with([
                'assignment.task',
                'assignment.group',
                'sistems',
                'user'
            ])
            ->get();

        return response()->json([
            'data' => $assignmentUsers,
            'count' => $assignmentUsers->count()
        ]);
    }
}
