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
            return $this->groupService->getGroupsByUserId($user->id)->load('user');
        } else if ($user->hasRole('mahasiswa')) {
            return $this->groupService->getGroupsByUserId($user->id)->load('user');
        }

        return GroupResource::collection($this->groupService->getAllPaginated($request->query(), $perPage)->load('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request) {

        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_CREATE_GROUP->value:
                return $this->groupService->create($request->validated());
            case IntentEnum::API_USER_JOIN_GROUP->value:
                return $this->groupService->joinGroup($request->validated());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group) {
        return new GroupResource($group->load('user'));
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
