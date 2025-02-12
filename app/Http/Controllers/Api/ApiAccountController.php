<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Account\StoreAccountRequest;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Support\Interfaces\Services\AccountServiceInterface;
use Illuminate\Http\Request;

class ApiAccountController extends ApiController {
    public function __construct(
        protected AccountServiceInterface $accountService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return AccountResource::collection($this->accountService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request) {
        return $this->accountService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account) {
        return new AccountResource($account);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account) {
        return $this->accountService->update($account, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Account $account) {
        return $this->accountService->delete($account);
    }
}