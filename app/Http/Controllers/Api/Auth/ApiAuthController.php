<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Contract;
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
            ]);
        }

        return response()->json([
            'message' => __('auth.failed'),
        ], 401);
    }

    // REGISTER
    public function register(ApiAuthRegisterRequest $request) {
        $contract = Contract::where('contract_code', $request->contract_code)->first();
        $currentStudentCount = User::join('user_roles', 'users.id', '=', 'user_roles.user_id')
        ->join('roles', 'user_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'mahasiswa')
        ->where('users.contract_id', $contract->id)
        ->count();
        if ($currentStudentCount >= $contract->qty_student) {
            return response()->json([
                'message' => 'Student quota for this University has been reached',
            ], 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'contract_id' => $contract->id,
        ]);
        $user->roles()->attach(Role::where('name', 'mahasiswa')->first());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
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
