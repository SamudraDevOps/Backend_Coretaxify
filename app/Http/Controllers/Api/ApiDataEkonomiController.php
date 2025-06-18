<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\DataEkonomi;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\DataEkonomiResource;
use App\Http\Requests\DataEkonomi\StoreDataEkonomiRequest;
use App\Http\Requests\DataEkonomi\UpdateDataEkonomiRequest;
use App\Support\Interfaces\Services\DataEkonomiServiceInterface;

class ApiDataEkonomiController extends ApiController {
    public function __construct(
        protected DataEkonomiServiceInterface $dataEkonomiService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 20);

        return DataEkonomiResource::collection($this->dataEkonomiService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDataEkonomiRequest $request) {
        return $this->dataEkonomiService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, DataEkonomi $dataEkonomi, Request $request) {

        $dataEkonomi = $this->dataEkonomiService->getdataEkonomiDetail(
            $assignment,
            $sistem,
            $dataEkonomi,
            $request
        );

        return new DataEkonomiResource($dataEkonomi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateDataEkonomiRequest $request, DataEkonomi $dataEkonomi) {

        $dataEkonomi = $this->dataEkonomiService->updateDataEkonomi(
            $assignment,
            $sistem,
            $dataEkonomi,
            $request->validated()
        );

        return new DataEkonomiResource($dataEkonomi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DataEkonomi $dataEkonomi) {
        return $this->dataEkonomiService->delete($dataEkonomi);
    }
}
