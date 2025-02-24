<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use App\Models\Contract;
use App\Mail\SendOtpMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Services\FileUploadService;
use App\Http\Resources\AuthResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\ApiAuthLoginRequest;
use App\Http\Requests\Auth\ApiAuthUpdateRequest;
use App\Http\Requests\Auth\ApiAuthRegisterRequest;
use App\Http\Requests\Auth\ApiAuthResendOtpRequest;
use App\Http\Requests\Auth\ApiAuthVerifyOtpRequest;
use App\Http\Requests\Auth\ApiAuthResetPasswordRequest;

class ApiAuthController extends ApiController {


    public function __construct(
        protected FileUploadService $fileService
    ) {}


    // LOGIN
    public function login(ApiAuthLoginRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user->email_verified_at) {
            return response()->json(['message' => 'Please verify your email with the OTP before logging in.'], 403);
        }

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

        if (str_starts_with($validated['contract_code'], 'PSC-')) {
            $group = Group::where('class_code', $validated['contract_code'])->firstOrFail();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'default_password' => $validated['password']
            ]);

            $user->roles()->attach(Role::where('name', 'mahasiswa-psc')->first());
            $user->groups()->attach($group->id);

            // generate and send otp
            $user->generateOtp();
            Mail::to($user->email)->send(new SendOtpMail($user->email_otp));

            // $user->createToken('auth_token')->plainTextToken;

            // return new AuthResource($user);
            return response()->json(['message' => 'OTP sent to your email. Please verify your account.']);

        }

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

        $user->generateOtp();
        Mail::to($user->email)->send(new SendOtpMail($user->email_otp));
        // $user->createToken('auth_token')->plainTextToken;

        // return new AuthResource($user);
        return response()->json(['message' => 'OTP sent to your email. Please verify your account.']);
    }

    public function resetPassword(ApiAuthResetPasswordRequest $request) {
        $user = User::where('email', $request->validated('email'))->first();

        if($user->default_password) {
            $user->update([
                'password' => $user->default_password
            ]);
        } else {
            $newPassword = Str::random(8);
            $user->update([
                'password' => $newPassword,
                'default_password' => $newPassword
            ]);

        }

        Mail::to($user->email)->send(new PasswordResetMail($user));

        return response()->json([
            'message' => 'Password reset successfully. Check your email for your password.',
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
            'data' => new UserResource($user),
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

    public function verifyOtp(ApiAuthVerifyOtpRequest $request) {
        $user = User::where('email', $request->validated('email'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        if ($user->email_otp !== $request->validated('otp')) {
            return response()->json([
                'message' => 'Invalid OTP',
            ], 400);
        }

        if ($user->email_otp_expires_at->isPast()) {
            return response()->json([
                'message' => 'OTP has expired. Please request a new one.',
            ], 400);
        }

        // is verified
        $user->email_verified_at = now();
        $user->email_otp = null;
        $user->email_otp_expires_at = null;
        $user->save();

        return response()->json([
            'message' => 'Email verified successfully. You can now login.',
        ]);
    }

    public function resendOtp(ApiAuthResendOtpRequest $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($user->email_verified_at) {
            return response()->json([
                'message' => 'Email is already verified'
            ], 400);
        }

        // Generate and send new OTP
    $user->generateOtp();
    Mail::to($user->email)->send(new SendOtpMail($user->email_otp));

    return response()->json(['message' => 'New OTP sent to your email.']);
    }
}
