<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ContractTask\StoreContractTaskRequest;
use App\Http\Requests\ContractTask\UpdateContractTaskRequest;
use App\Http\Resources\ContractTaskResource;
use App\Models\ContractTask;
use App\Support\Interfaces\Services\ContractTaskServiceInterface;
use Illuminate\Http\Request;

class ApiContractTaskController extends ApiController {
    public function __construct(
        protected ContractTaskServiceInterface $contractTaskService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return ContractTaskResource::collection($this->contractTaskService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractTaskRequest $request) {
        return $this->contractTaskService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(ContractTask $contractTask) {
        return new ContractTaskResource($contractTask);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractTaskRequest $request, ContractTask $contractTask) {
        return $this->contractTaskService->update($contractTask, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ContractTask $contractTask) {
        return $this->contractTaskService->delete($contractTask);
    }
}
