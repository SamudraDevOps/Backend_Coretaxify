<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Support\Interfaces\Services\RoleServiceInterface;
use Illuminate\Http\Request;

class ApiRoleController extends ApiController {
    public function __construct(
        protected RoleServiceInterface $roleService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return RoleResource::collection($this->roleService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request) {
        return $this->roleService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role) {
        return new RoleResource($role->load(['roles' => ['division', 'permissions']]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role) {
        return $this->roleService->update($role, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role) {
        return $this->roleService->delete($role);
    }
}