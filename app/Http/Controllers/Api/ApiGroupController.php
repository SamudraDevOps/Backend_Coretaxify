<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Support\Interfaces\Services\GroupServiceInterface;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;

class ApiGroupController extends ApiController {
    public function __construct(
        protected GroupServiceInterface $groupService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        $user = auth()->user();

        if ($user->hasRole('dosen')) {
            return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        } else if ($user->hasRole('mahasiswa')) {
            return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        } else if ($user->hasRole('psc')) {
            return $this->groupService->getGroupsByUserId($user->id)->load(['user', 'users', 'assignments']);
        }

        return GroupResource::collection($this->groupService->getAllPaginated($request->query(), $perPage)->load(['user', 'users', 'assignments']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request) {
        $intent = $request->get('intent');

        $user = auth()->user();

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_GROUP->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc')) {
                    return $this->groupService->create($request->validated());
                } else {
                    return response()->json([
                        'message' => 'You are not authorized to create a group',
                    ], 403);
                }
            case IntentEnum::API_USER_JOIN_GROUP->value:
                if ($user->hasRole('mahasiswa')) {
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
            case IntentEnum::API_USER_DOWNLOAD_SOAL->value:
                return $this->groupService->downloadFile($group);
            case IntentEnum::API_GET_GROUP_WITH_ASSIGNMENTS->value:
                if ($user->hasRole('dosen') || $user->hasRole('psc')) {
                    return new GroupResource($group->load('assignments'));
                } else if ($user->hasRole('mahasiswa')) {
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
                return new GroupResource($group->load('users',));
        }
        return new GroupResource($group->load(['users', 'assignments']));
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
}
