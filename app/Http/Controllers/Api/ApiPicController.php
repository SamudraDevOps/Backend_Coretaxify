<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Pic\StorePicRequest;
use App\Http\Requests\Pic\UpdatePicRequest;
use App\Http\Resources\PicResource;
use App\Models\Pic;
use App\Support\Interfaces\Services\PicServiceInterface;
use Illuminate\Http\Request;

class ApiPicController extends ApiController {
    public function __construct(
        protected PicServiceInterface $picService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);

        return PicResource::collection($this->picService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePicRequest $request) {
        return $this->picService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Pic $pic) {
        return new PicResource($pic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePicRequest $request, Pic $pic) {
        return $this->picService->update($pic, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pic $pic) {
        return $this->picService->delete($pic);
    }
}