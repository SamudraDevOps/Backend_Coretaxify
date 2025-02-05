<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\ApiAuthLoginRequest;
use App\Http\Requests\Auth\ApiAuthRegisterRequest;

class ApiAuthController extends ApiController {

    // LOGIN
    public function login(ApiAuthLoginRequest $request) {
        if (auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'user' => new UserResource(auth()->user()),
                'token' => auth()->user()->createToken('auth_token')->plainTextToken,
                'role' => new RoleResource(auth()->user()->roles()->first()),
            ]);
        }

        return response()->json([
            'message' => __('auth.failed'),
        ], 401);
    }

    // LOGOUT
    public function logout() {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => __('auth.logout'),
        ]);
    }

    public function me(Request $request) {
        return new UserResource($request->user());
    }
}
