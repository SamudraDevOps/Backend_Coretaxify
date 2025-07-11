<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\SistemTambahan;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\SistemTambahanResource;
use App\Http\Requests\SistemTambahan\StoreSistemTambahanRequest;
use App\Http\Requests\SistemTambahan\UpdateSistemTambahanRequest;
use App\Support\Interfaces\Services\SistemTambahanServiceInterface;

class ApiSistemTambahanController extends ApiController {
    public function __construct(
        protected SistemTambahanServiceInterface $sistemTambahanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    /**
 * Display a listing of the resource.
 */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = request()->get('perPage', 20);

        // Query data berdasarkan assignment_user_id dari sistem
        $data = SistemTambahan::where('assignment_user_id', $sistem->assignment_user->id)
            ->paginate($perPage);

        return SistemTambahanResource::collection($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment,Sistem $sistem ,Request $request) {
        $this->sistemTambahanService->authorizeAccess($assignment, $sistem);

        $request['assignment_user_id'] = $sistem->assignment_user->id;

        return $this->sistemTambahanService->create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment,Sistem $sistem ,SistemTambahan $sistemTambahan) {
        return new SistemTambahanResource($sistemTambahan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateSistemTambahanRequest $request, SistemTambahan $sistemTambahan) {
    return $this->sistemTambahanService->update($sistemTambahan, $request->validated());
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment,Sistem $sistem , Request $request, SistemTambahan $sistemTambahan) {
        return $this->sistemTambahanService->delete($sistemTambahan);
    }
}
