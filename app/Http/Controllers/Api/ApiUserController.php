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

        switch($validated['intent']) {
            case IntentEnum::API_USER_IMPORT_DOSEN->value:
                return $this->userService->importData($validated);
            case IntentEnum::API_USER_IMPORT_MAHASISWA->value:
                return $this->userService->importData($validated);
        }

        return $this->userService->create($validated);

        // $intent = $request->get('intent');

        // switch ($intent) {
        //     // case IntentEnum::API_USER_IMPORT_DOSEN->value:
        //     //     $this->userService->importData($request->file('import_file'));
        //     //     return response()->noContent();
        //     case IntentEnum::API_USER_CREATE_INSTRUCTOR->value:
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
        return $this->userService->delete($user);
    }
}
