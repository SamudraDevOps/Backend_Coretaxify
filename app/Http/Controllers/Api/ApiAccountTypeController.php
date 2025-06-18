<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AccountType\StoreAccountTypeRequest;
use App\Http\Requests\AccountType\UpdateAccountTypeRequest;
use App\Http\Resources\AccountTypeResource;
use App\Models\AccountType;
use App\Support\Interfaces\Services\AccountTypeServiceInterface;
use Illuminate\Http\Request;

class ApiAccountTypeController extends ApiController {
    public function __construct(
        protected AccountTypeServiceInterface $accountTypeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return AccountTypeResource::collection($this->accountTypeService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountTypeRequest $request) {
        return $this->accountTypeService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountType $accountType) {
        return new AccountTypeResource($accountType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountTypeRequest $request, AccountType $accountType) {
        return $this->accountTypeService->update($accountType, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, AccountType $accountType) {
        return $this->accountTypeService->delete($accountType);
    }
}
