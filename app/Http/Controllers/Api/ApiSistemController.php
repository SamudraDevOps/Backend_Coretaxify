<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Sistem\StoreSistemRequest;
use App\Http\Requests\Sistem\UpdateSistemRequest;
use App\Http\Resources\SistemResource;
use App\Http\Resources\PortalSayaResource;
use App\Models\PortalSaya;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use App\Support\Interfaces\Services\SistemServiceInterface;
use Illuminate\Http\Request;

class ApiSistemController extends ApiController {
    public function __construct(
        protected SistemServiceInterface $sistemService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $perPage = request()->get('perPage', 5);
        return SistemResource::collection($this->sistemService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSistemRequest $request) {
        return $this->sistemService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Sistem $sistem) {
        return new SistemResource($sistem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSistemRequest $request, Sistem $sistem) {

        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_USER_UPDATE_KUASA_WAJIB->value:
                return $this->sistemService->updateKuasaWajib($request->validated());
        }

        return $this->sistemService->update($sistem, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Sistem $sistem) {
        return $this->sistemService->delete($sistem);
    }

    public function getSistems(Assignment $assignment)
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        return $assignmentUser->sistems; // Using the relationship defined in AssignmentUser
    }

    public function getSistemDetail(Assignment $assignment, Sistem $sistem, Request $request)
    {
        $intent = $request->get('intent');

        switch ($intent) {
            case IntentEnum::API_GET_SISTEM_ALAMAT->value:
                $assignmentUser = AssignmentUser::where([
                    'user_id' => auth()->id(),
                    'assignment_id' => $assignment->id
                ])->firstOrFail();

                if ($sistem->assignment_user_id !== $assignmentUser->id) {
                    abort(403);
                }

                $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)
                                   ->where('id', $sistem->id)
                                   ->firstOrFail();

                return new SistemResource($sistems);
            case IntentEnum::API_GET_SISTEM_IKHTISAR_PROFIL->value:
                $assignmentUser = AssignmentUser::where([
                    'user_id' => auth()->id(),
                    'assignment_id' => $assignment->id
                ])->firstOrFail();

                if ($sistem->assignment_user_id !== $assignmentUser->id) {
                    abort(403);
                }

                $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)
                                   ->where('id', $sistem->id)
                                   ->firstOrFail();

                return new SistemResource($sistems);
            case IntentEnum::API_SISTEM_GET_AKUN_ORANG_PIBADI->value:
                $assignmentUser = AssignmentUser::where([
                    'user_id' => auth()->id(),
                    'assignment_id' => $assignment->id
                ])->firstOrFail();

                if ($sistem->assignment_user_id !== $assignmentUser->id) {
                    abort(403);
                }

                $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)
                                   ->whereIn('tipe_akun', ['Orang Pribadi', 'Orang Pribadi Lawan Transaksi'])
                                   ->get();

                return SistemResource::collection($sistems);
            case IntentEnum::API_SISTEM_GET_PORTAL_SAYA->value:
                $assignmentUser = AssignmentUser::where([
                    'user_id' => auth()->id(),
                    'assignment_id' => $assignment->id
                ])->firstOrFail();

                if ($sistem->assignment_user_id !== $assignmentUser->id) {
                    abort(403);
                }

                $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)
                                   ->where('id', $sistem->id)
                                   ->firstOrFail();

                return new PortalSayaResource($sistems->portal_saya);
            default:
                $assignmentUser = AssignmentUser::where([
                    'user_id' => auth()->id(),
                    'assignment_id' => $assignment->id
                ])->firstOrFail();

                if ($sistem->assignment_user_id !== $assignmentUser->id) {
                    abort(403);
                }

                $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)
                                   ->where('id', $sistem->id)
                                   ->firstOrFail();

                return new SistemResource($sistems);
        }
    }
}