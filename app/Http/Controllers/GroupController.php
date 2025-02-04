<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\StoreGroupRequest;
use App\Http\Requests\Group\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use App\Support\Interfaces\Services\GroupServiceInterface;
use Illuminate\Http\Request;

class GroupController extends Controller {
    public function __construct(protected GroupServiceInterface $GroupService) {}

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
    public function store(StoreGroupRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Group $Group) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Group $Group) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $Group) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Group $Group) {
        //
    }
}