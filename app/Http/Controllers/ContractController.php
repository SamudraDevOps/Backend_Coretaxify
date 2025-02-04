<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;
use App\Http\Resources\ContractResource;
use App\Models\Contract;
use App\Support\Interfaces\Services\ContractServiceInterface;
use Illuminate\Http\Request;

class ContractController extends Controller {
    public function __construct(protected ContractServiceInterface $ContractService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Contract $Contract) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Contract $Contract) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, Contract $Contract) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Contract $Contract) {
        //
    }
}