<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use App\Support\Interfaces\Services\ContractServiceInterface;
use Illuminate\Http\Request;

class ApiContractController extends ApiController {
    public function __construct(
        protected ContractServiceInterface $contractService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return ContractResource::collection($this->contractService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request) {
        return $this->contractService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract) {
        return new ContractResource($contract->load(['roles' => ['division', 'permissions']]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $contract) {
        return $this->contractService->update($contract, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Contract $contract) {
        return $this->contractService->delete($contract);
    }
}