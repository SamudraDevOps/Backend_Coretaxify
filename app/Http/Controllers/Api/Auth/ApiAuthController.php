<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use App\Models\Contract;
use App\Mail\SendOtpMail;
use App\Support\Enums\UserStatusEnum;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Services\FileUploadService;
use App\Http\Resources\AuthResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;
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
        $credentials = $request->validated();
        $user = User::where('email', $request->email)->first();

        if ($user && !auth()->attempt($credentials)) {
            return response()->json([
                'message' => "Mohon maaf, password anda salah.",
            ], 401);

        }

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => "Mohon maaf, akun anda tidak terdaftar.",
                // 'message' => __('auth.failed'),
            ], 401);
        }

        $user = auth()->user();

        if (!$user->email_verified_at) {
            return response()->json([
                'message' => 'Mohon verifikasi email anda terlebih dahulu.',
                'verification_required' => true,
                'user' => new UserResource($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 403);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->email_verified_at) {
            return response()->json(['message' => 'Mohon verifikasi email anda terlebih dahulu.'], 403);
        }

        if (auth()->attempt($request->validated())) {
            return response()->json([
                'user' => new UserResource(auth()->user()),
                'token' => auth()->user()->createToken('auth_token')->plainTextToken,
            ]);
        }
    }

    // REGISTER
    public function register(ApiAuthRegisterRequest $request) {
        $validated = $request->validated();

        $contract = Contract::where('contract_code', $request->contract_code)->first();

        if (!$contract) {
            // if (str_starts_with($validated['contract_code'], 'PSC-')) {
            $group = Group::where('class_code', $validated['contract_code'])->first();

            if (!$group) {
                throw new \Exception('Kode Registrasi yang Anda masukkan tidak Valid. Mohon hubungi Admin apabila ada kendala.');
            } else if (!$group->user->hasRole('psc')) {
                throw new \Exception('Kode Registrasi yang Anda masukkan tidak Valid. Mohon hubungi Admin apabila ada kendala.');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'email_verified_at' => now(),
                'password' => $validated['password'],
                'default_password' => $validated['password'],
                'status' => UserStatusEnum::ACTIVE->value,
            ]);

            $user->roles()->attach(Role::where('name', 'mahasiswa-psc')->first());
            $user->groups()->attach($group->id);

            // generate and send otp
            $user->generateOtp();
            Mail::to($user->email)->send(new SendOtpMail($user->email_otp));

            // Create token for the newly registered user
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'OTP sent to your email. Please verify your account.',
                'user' => new UserResource($user),
                'token' => $token,
                'verification_required' => true
            ]);
        }

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
            'email_verified_at' => now(),
            'password' => $validated['password'],
            'contract_id' => $contract->id,
            'status' => UserStatusEnum::ACTIVE->value,
        ]);

        $user->roles()->attach(Role::where('name', 'mahasiswa')->first());

        $user->generateOtp();
        Mail::to($user->email)->send(new SendOtpMail($user->email_otp));

        // Create token for the newly registered user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'OTP sent to your email. Please verify your account.',
            'user' => new UserResource($user),
            'token' => $token,
            'verification_required' => true
        ]);
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

        // Mail::to($user->email)->send(new PasswordResetMail($user));

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
        $user = null;

        // check if user authenticated
        if (auth()->check()) {
            $user = auth()->user();
        }

        elseif ($request->has('token')) {
            $token = $request->token;
            $tokenParts = explode('|', $token);
            $tokenId = $tokenparts[0] ?? null;

            if ($tokenId) {
                $personalAccessToken = PersonalAccessToken::find($tokenId);
                if ($personalAccessToken) {
                    $user = $personalAccessToken->tokenable;
                }
            }
        }

        elseif ($request->has('email')) {
            $user = User::where('email', $request->validated('email'))->first();
        }

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

        // if ($user->email_otp_expires_at->isPast()) {
        //     return response()->json([
        //         'message' => 'OTP has expired. Please request a new one.',
        //     ], 400);
        // }

        // is verified
        $user->email_verified_at = now();
        $user->email_otp = null;
        $user->email_otp_expires_at = null;
        $user->save();

        if (auth()->check()) {
            return response()->json([
                'message' => 'Email verified successfully.',
            ]);
        }

        return response()->json([
            'message' => 'Email verified successfully. You can now login.',
            'user' => new UserResource($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
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

    public function verificationStatus(Request $request) {
        $user = $request->user();

        return response()->json([
            'verified' => !is_null($user->email_verified_at),
            'email' => $user->email
        ]);
    }
}
