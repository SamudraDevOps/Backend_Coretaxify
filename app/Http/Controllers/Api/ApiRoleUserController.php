<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RoleUser\StoreRoleUserRequest;
use App\Http\Requests\RoleUser\UpdateRoleUserRequest;
use App\Http\Resources\RoleUserResource;
use App\Models\RoleUser;
use App\Support\Interfaces\Services\RoleUserServiceInterface;
use Illuminate\Http\Request;

class ApiRoleUserController extends ApiController {
    public function __construct(
        protected RoleUserServiceInterface $roleUserService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return RoleUserResource::collection($this->roleUserService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleUserRequest $request) {
        return $this->roleUserService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleUser $roleUser) {
        return new RoleUserResource($roleUser->load(['roles' => ['division', 'permissions']]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleUserRequest $request, RoleUser $roleUser) {
        return $this->roleUserService->update($roleUser, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, RoleUser $roleUser) {
        return $this->roleUserService->delete($roleUser);
    }
}