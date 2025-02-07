<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use App\Services\FileUploadService;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\ApiAuthLoginRequest;
use App\Http\Requests\Auth\ApiAuthRegisterRequest;
use App\Http\Requests\Auth\ApiAuthUpdateRequest;

class ApiAuthController extends ApiController {


    public function __construct(
        protected FileUploadService $fileService
    ) {}


    // LOGIN
    public function login(ApiAuthLoginRequest $request) {
        if (auth()->attempt($request->validated())) {
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
        $validated = $request->validated();

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
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'contract_id' => $contract->id,
        ]);
        $user->roles()->attach(Role::where('name', 'mahasiswa')->first());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'data' => new UserResource($user),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    // UPDATE PROFILE
    public function updateProfile(ApiAuthUpdateRequest $request) {
        $validated = $request->validated();
        $user = auth()->user();

        if ($request->hasFile('image')) {
            $this->fileService->deleteImage($user->image);
            $validated['image_path'] = $this->fileService->uploadImage($request->file('image'));
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $user
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
