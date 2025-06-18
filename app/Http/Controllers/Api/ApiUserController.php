<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Support\Enums\IntentEnum;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Support\Interfaces\Services\UserServiceInterface;

class ApiUserController extends ApiController {
    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return UserResource::collection($this->userService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request) {

        $validated = $request->validated();
        $validated['intent'] = $request->get('intent');


        // bulk creation
        if ($request->has('bulk') && $request->boolean('bulk') && $request->has('students')) {
            $students = [];
            $intent = $validated['intent']; // Get the intent once

            // check if all data is not duplicated in database
            foreach($request->input('students') as $studentData) {
                if (User::where('email', $studentData['email'])->exists()) {
                    return throw new \Exception('Email telah didaftarkan: ' . $studentData['email']);
                }
            }

            foreach ($request->input('students') as $studentData) {
                // Add intent to each student's data
                $studentData['intent'] = $intent;

                // Create the student using your existing service
                $student = $this->userService->create($studentData);
                $students[] = $student;
            }

            return response()->json([
                'message' => 'Students created successfully',
                'data' => $students
            ], 201);
        }

        // single creation
        switch($validated['intent']) {
            case IntentEnum::API_USER_IMPORT_DOSEN->value:
                return $this->userService->importData($validated);
            case IntentEnum::API_USER_IMPORT_MAHASISWA_PSC->value:
                return $this->userService->importData($validated);
            case IntentEnum::API_USER_IMPORT_INSTRUKTUR->value:
                return $this->userService->importData($validated);
        }

        return $this->userService->create($validated);

        // $intent = $request->get('intent');

        // switch ($intent) {
        //     // case IntentEnum::API_USER_IMPORT_DOSEN->value:
        //     //     $this->userService->importData($request->file('import_file'));
        //     //     return response()->noContent();
        //     case IntentEnum::API_USER_CREATE_INSTRUKTUR->value:
        //         return $this->userService->create($request->validated());
        //     default:
        //         return $this->userService->create($request->validated());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user) {
        return $this->userService->update($user, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user) {
        $authUser = auth()->user();
        if ($authUser->hasRole('admin')) {
            try {
                return $this->userService->delete($user);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => "Penghapusan pengguna tidak diizinkan. Pengguna telah terdaftar pada kelas atau praktikum."
                ], );
            }
        }
        return response()->json([
            'message' => 'Anda tidak diizinkan untuk menghapus data pengguna ini.'
        ], 403);
    }
}
