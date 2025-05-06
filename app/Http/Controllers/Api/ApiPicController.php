<?php

namespace App\Http\Controllers\Api;

use App\Models\Pic;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PicResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SistemResource;
use App\Http\Requests\Pic\StorePicRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Pic\UpdatePicRequest;
use App\Support\Interfaces\Services\PicServiceInterface;

class ApiPicController extends ApiController
{
    public function __construct(
        protected PicServiceInterface $picService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = request()->get('perPage', 5);

        return PicResource::collection($this->picService->getAllPaginated($request->query(), $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePicRequest $request)
    {
        return $this->picService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Pic $pic)
    {
        return new PicResource($pic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePicRequest $request, Pic $pic)
    {
        return $this->picService->update($pic, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pic $pic)
    {
        return $this->picService->delete($pic);
    }

    /**
     * Get all companies that a personal account can represent
     */
    /**
     * Get companies that the personal account can represent
     */
    public function getRepresentedCompanies(Assignment $assignment, Sistem $sistem)
    {
        // Ensure this is a personal account
        if ($sistem->tipe_akun !== 'Orang Pribadi' && $sistem->tipe_akun !== 'Orang Pribadi Lawan Transaksi') {
            return response()->json(['message' => 'Akses ini hanya diperuntukkan untuk akun OP'], 400);
        }

        // Get assignment user
        $assignmentUser = AssignmentUser::where([
            'user_id' => Auth::id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        // Get companies that this personal account can represent
        $companyIds = Pic::where('akun_op_id', $sistem->id)
            ->where('assignment_user_id', $assignmentUser->id)
            ->pluck('akun_badan_id');

        $companies = Sistem::whereIn('id', $companyIds)->get();

        return SistemResource::collection($companies);
    }

    /**
     * Get representatives of a company account
     */
    public function getCompanyRepresentatives(Assignment $assignment, Sistem $sistem)
    {
        // Ensure this is a company account
        if ($sistem->tipe_akun !== 'Badan' && $sistem->tipe_akun !== 'Badan Lawan Transaksi') {
            return response()->json(['message' => 'Akses ini hanya diperuntukkan untuk akun badan'], 400);
        }

        // Get assignment user
        $assignmentUser = AssignmentUser::where([
            'user_id' => Auth::id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        // Get personal accounts that can represent this company
        $personalAccountIds = Pic::where('akun_badan_id', $sistem->id)
            ->where('assignment_user_id', $assignmentUser->id)
            ->pluck('akun_op_id');

        $personalAccounts = Sistem::whereIn('id', $personalAccountIds)->get();

        return SistemResource::collection($personalAccounts);
    }

    /**
     * Assign a personal account as a representative for a company
     */
    public function assignRepresentative(Request $request, Assignment $assignment, Sistem $sistem)
    {
        // Validate request
        $request->validate([
            'personal_id' => 'required|exists:sistems,id'
        ]);

        // Create the representation
        $pic = Pic::create([
            'akun_op_id' => $request->personal_id,
            'akun_badan_id' => $sistem->id,
            'assignment_user_id' => $sistem->assignment_user_id
        ]);

        return new PicResource($pic);
    }

    /**
     * Check if a personal account can represent a company
     */
    public function checkRepresentation(Request $request, Assignment $assignment, Sistem $sistem)
    {
        // Validate request
        $request->validate([
            'company_id' => 'required|exists:sistems,id'
        ]);

        // Check if representation exists
        $canRepresent = Pic::where('akun_op_id', $sistem->id)
            ->where('akun_badan_id', $request->company_id)
            ->where('assignment_user_id', $sistem->assignment_user_id)
            ->exists();

        return response()->json([
            'can_represent' => $canRepresent,
            'message' => $canRepresent
                ? 'Akun OP ini dapat mewakili perusahaan ini'
                : 'Akun OP ini tidak dapat mewakili perusahaan ini'
        ]);
    }
}
