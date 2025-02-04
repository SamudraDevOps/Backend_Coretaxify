<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\GroupUser\StoreGroupUserRequest;
use App\Http\Requests\GroupUser\UpdateGroupUserRequest;
use App\Http\Resources\GroupUserResource;
use App\Models\GroupUser;
use App\Support\Interfaces\Services\GroupUserServiceInterface;
use Illuminate\Http\Request;

class ApiGroupUserController extends ApiController {
    public function __construct(
        protected GroupUserServiceInterface $groupUserService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return GroupUserResource::collection($this->groupUserService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupUserRequest $request) {
        return $this->groupUserService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(GroupUser $groupUser) {
        return new GroupUserResource($groupUser->load(['roles' => ['division', 'permissions']]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupUserRequest $request, GroupUser $groupUser) {
        return $this->groupUserService->update($groupUser, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, GroupUser $groupUser) {
        return $this->groupUserService->delete($groupUser);
    }
}