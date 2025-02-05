<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Support\Interfaces\Services\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleController extends Controller {
    public function __construct(protected RoleServiceInterface $RoleService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Role $Role) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Role $Role) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $Role) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $Role) {
        //
    }
}