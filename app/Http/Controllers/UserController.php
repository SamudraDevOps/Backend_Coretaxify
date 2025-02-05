<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
// use App\Support\Interfaces\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller {
    // public function __construct(protected UserServiceInterface $UserService) {}

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
    public function store(StoreUserRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $User) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $User) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $User) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $User) {
        //
    }
}