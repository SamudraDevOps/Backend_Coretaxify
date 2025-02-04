<?php

namespace App\Http\Controllers;

use App\Http\Requests\University\StoreUniversityRequest;
use App\Http\Requests\University\UpdateUniversityRequest;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use App\Support\Interfaces\Services\UniversityServiceInterface;
use Illuminate\Http\Request;

class UniversityController extends Controller {
    public function __construct(protected UniversityServiceInterface $UniversityService) {}

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
    public function store(StoreUniversityRequest $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, University $University) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, University $University) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUniversityRequest $request, University $University) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, University $University) {
        //
    }
}