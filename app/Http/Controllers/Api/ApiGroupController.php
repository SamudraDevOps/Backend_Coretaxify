<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\GroupResource;
use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Support\Interfaces\Services\GroupServiceInterface;

class ApiGroupController extends ApiController {
    public function __construct(
        protected GroupServiceInterface $groupService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);
        $intent = request()->get('intent');
        $user = auth()->user();

        switch($intent) {
            case IntentEnum::API_GET_GROUP_BY_ROLES->value:
                $groups = $this->groupService->getGroupsByUserRole($user);
                return GroupResource::collection($groups);
            default:
                $groups = $this->groupService->getGroupsByUserId($user->id);
                return GroupResource::collection($groups);
        }



        // if ($user->hasRole('dosen') || $user->hasRole('psc')) {
        //     return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        // } else if ($user->hasRole('mahasiswa')) {
        //     return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        // } else if ($user->hasRole('mahasiswa-psc')) {
        //     return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        // } else if ($user->hasRole('psc')) {
        //     return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        // }

        // return GroupResource::collection($this->groupService->getAllPaginated($request->query(), $perPage)->load(['user', 'users', 'assignments']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request) {
        $intent = $request->get('intent');

        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_GROUP->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('admin')) {
                    return $this->groupService->create($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to create a group',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_GROUP->value:
                if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
                    return $this->groupService->joinGroup($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to join a group',
                    ], 403);
                }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Group $group) {
        $intent = $request->get('intent');

        $user = auth()->user();

        switch($intent) {
            // case IntentEnum::API_USER_DOWNLOAD_SOAL->value:
            //     return $this->groupService->downloadFile($group);
            case IntentEnum::API_GET_GROUP_WITH_ASSIGNMENTS->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc') || $user->hasRole('admin')) {
                    return new GroupResource($group->load('assignments'));
                } else if ($user->hasRole('mahasiswa') || $user->hasRole('mahasiswa-psc')) {
                    $userId = $user->id;

                    $group->load([
                        'assignments' => function ($query) use ($userId) {
                            $query->whereHas('users', function ($query) use ($userId) {
                                $query->where('user_id', $userId);
                            });
                        },
                    ]);

                    return new GroupResource($group);
                }
            case IntentEnum::API_GET_GROUP_WITH_MEMBERS->value:
                return new GroupResource($group->load('users'));
        }
        return new GroupResource($group->load(['user', 'assignments']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group) {
        return $this->groupService->update($group, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Group $group) {
        return $this->groupService->delete($group);
    }

    public function getMembers(Group $group) {
        return new GroupResource($group->load('users'));
    }

    public function removeMember(Group $group, User $user) {
        $group->users()->detach($user->id);
        return response()->json(['message' => 'Member removed successfully']);
    }

    public function getMemberDetail(Group $group, User $user) {
        return $group->users()->findOrFail($user->id);
    }
}
