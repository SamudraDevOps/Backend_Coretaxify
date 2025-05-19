<?php

namespace App\Http\Controllers\Api;

use App\Models\Faktur;
use App\Models\Sistem;
use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Models\SistemTambahan;
use App\Models\DetailTransaksi;
use App\Http\Resources\FakturResource;
use App\Support\Enums\FakturStatusEnum;
use App\Http\Resources\CombinedAccountResource;
use App\Http\Requests\Faktur\StoreFakturRequest;
use App\Http\Requests\Faktur\UpdateFakturRequest;
use App\Support\Interfaces\Services\PicServiceInterface;
use App\Support\Interfaces\Services\FakturServiceInterface;
use App\Support\Interfaces\Services\PermissionServiceInterface;
use App\Http\Requests\DetailTransaksi\StoreDetailTransaksiRequest;

class ApiFakturController extends ApiController
{
    public function __construct(
        protected FakturServiceInterface $fakturService,
        protected PermissionServiceInterface $permissionService,
        protected PicServiceInterface $picService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request)
    {
        $perPage = request()->get('perPage', 10);

        // For personal accounts, check if they're representing a company
        $representedCompanyId = $request->input('company_id');
        $representedCompany = null;

        if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
            $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

            // Check if this personal account can represent the company
            if (!$this->permissionService->canPerformFakturAction($sistem, 'view', $representedCompany)) {
                return response()->json(['message' => 'You cannot represent this company'], 403);
            }

            // Use the company's ID to filter fakturs
            $filters = array_merge($request->query(), ['sistem_id' => $representedCompany->id]);
        } else {
            // Use the current sistem's ID
            $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);
        }

        $fakturs = $this->fakturService->getAllPaginated($filters, $perPage);

        $fakturs = $this->fakturService->getAllForSistem(
            $assignment,
            $sistem,
            $request,
            $perPage
        );

        return FakturResource::collection($fakturs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreFakturRequest $request)
    {
        $data = $request->validated();
        $data['intent'] = $request->input('intent', null); // Get intent from request or use null

        // For personal accounts, check if they're representing a company
        $representedCompanyId = $request->input('company_id');
        $representedCompany = null;

        if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
            $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

            // Check if this personal account can represent the company
            if (!$this->permissionService->canPerformFakturAction($sistem, 'create', $representedCompany)) {
                return response()->json(['message' => 'You cannot represent this company'], 403);
            }

            // Use the company's ID for the faktur
            $data = array_merge($request->all(), ['sistem_id' => $representedCompany->id]);
        } else {
            // Use the current sistem's ID
            $data = array_merge($request->all(), ['sistem_id' => $sistem->id]);
        }

        // $this->fakturService->getAllForSistem($assignment, $sistem, new Request(), 1);

        $faktur = $this->fakturService->create($data, $sistem);

        return new FakturResource($faktur);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Assignment $assignment, Sistem $sistem, Faktur $faktur)
    {
        // For personal accounts, check if they're representing a company
        $representedCompanyId = $request->input('company_id');
        $representedCompany = null;

        if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
            $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

            // Check if this personal account can represent the company
            if (!$this->permissionService->canPerformFakturAction($sistem, 'view', $representedCompany)) {
                return response()->json(['message' => 'You cannot represent this company'], 403);
            }

            // Check if the faktur belongs to the represented company
            if ($faktur->akun_pengirim_id !== $representedCompany->id) {
                return response()->json(['message' => 'Faktur not found for this company'], 404);
            }
        } else {
            // Check if the faktur belongs to the current sistem
            // if ($faktur->akun_pengirim_id !== $sistem->id) {
            //     return response()->json(['message' => 'Faktur not found'], 404);
            // }
            $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);
        }
    // public function show(Assignment $assignment, Sistem $sistem, Faktur $faktur) {


        $faktur->load('detail_transaksis');

        return new FakturResource($faktur);

        // $this->fakturService->getAllForSistem($assignment, $sistem, new Request(), 1);
        // return new FakturResource($faktur);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateFakturRequest $request, Faktur $faktur) {
        $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);

        $data = $request->validated();
        $data['intent'] = $request->input('intent', null);

        $updatedFaktur = $this->fakturService->update($faktur, $data);
        $updatedFaktur->load('detail_transaksis');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Assignment $assignment, Sistem $sistem, Faktur $faktur)
    {
        // For personal accounts, check if they're representing a company
        $representedCompanyId = $request->input('company_id');
        $representedCompany = null;

        if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
            $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

            // Check if this personal account can represent the company
            if (!$this->permissionService->canPerformFakturAction($sistem, 'delete', $representedCompany)) {
                return response()->json(['message' => 'You cannot represent this company'], 403);
            }

            // Check if the faktur belongs to the represented company
            if ($faktur->akun_pengirim_id !== $representedCompany->id) {
                return response()->json(['message' => 'Faktur not found for this company'], 404);
            }
        } else {
            // Check if the faktur belongs to the current sistem
            if ($faktur->akun_pengirim_id !== $sistem->id) {
                return response()->json(['message' => 'Faktur not found'], 404);
            }
        }

        // Only draft fakturs can be deleted
        if ($faktur->status !== FakturStatusEnum::DRAFT->value) {
            return response()->json(['message' => 'Only draft fakturs can be deleted'], 400);
        }

        $result = $this->fakturService->delete($faktur);
    }

    public function deleteMultipleFakturs(Assignment $assignment, Sistem $sistem,Request $request)
    {
        $this->fakturService->authorizeAccess($assignment, $sistem);

        $fakturIds = $request->input('faktur_ids', []);

        if (empty($fakturIds)) {
            return response()->json(['message' => 'No faktur IDs provided'], 400);
        }

        $fakturs = Faktur::whereIn('id', $fakturIds)->get();
        foreach ($fakturs as $faktur) {
            $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);
        }

        Faktur::whereIn('id', $fakturIds)->delete();

        return response()->json(['message' => 'Fakturs deleted successfully']);
    }

    public function multipleDraftFakturToFix(Assignment $assignment, Sistem $sistem, Request $request)
    {
        $this->fakturService->authorizeAccess($assignment, $sistem);

        $fakturIds = $request->input('faktur_ids', []);

        if (empty($fakturIds)) {
            return response()->json(['message' => 'No faktur IDs provided'], 400);
        }

        $fakturs = Faktur::whereIn('id', $fakturIds)->get();
        foreach ($fakturs as $faktur) {
            $this->fakturService->authorizeFakturBelongsToSistem($faktur, $sistem);
        }

        Faktur::whereIn('id', $fakturIds)->update(['is_draft' => false, 'status' => FakturStatusEnum::APPROVED->value]);

        return response()->json(['message' => 'Fakturs berhasil dikirim ke SPT']);
    }

    public function getCombinedAkunData(Assignment $assignment, Sistem $sistem)
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
            ])->firstOrFail();


        $sistems = Sistem::where('assignment_user_id', $assignmentUser->id)->get()->map(function ($item) {
            $item->is_akun_tambahan = false;
            return $item;
        });
        $sistemTambahans = SistemTambahan::where('sistem_id', $sistem->id)->get()->map(function ($item) {
            $item->is_akun_tambahan = true;
            return $item;
        });
        // dd($sistemTambahans);

        return CombinedAccountResource::collection($sistems->concat($sistemTambahans));
    }

    public function deleteDetailTransaksi(Request $request, Assignment $assignment, Sistem $sistem, Faktur $faktur, $detailTransaksiId)
    {
        // For personal accounts, check if they're representing a company
        $representedCompanyId = $request->input('company_id');
        $representedCompany = null;

        if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
            $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

            // Check if this personal account can represent the company
            if (!$this->permissionService->canPerformFakturAction($sistem, 'update', $representedCompany)) {
                return response()->json(['message' => 'You cannot represent this company'], 403);
            }

            // Check if the faktur belongs to the represented company
            if ($faktur->akun_pengirim_id !== $representedCompany->id) {
                return response()->json(['message' => 'Faktur not found for this company'], 404);
            }
        } else {
            // Check if the faktur belongs to the current sistem
            if ($faktur->akun_pengirim_id !== $sistem->id) {
                return response()->json(['message' => 'Faktur not found'], 404);
            }
        }

        // Only draft fakturs can be updated
        if ($faktur->status !== 'draft') {
            return response()->json(['message' => 'Only draft fakturs can be updated'], 400);
        }

        $result = $this->fakturService->deleteDetailTransaksi($faktur, $detailTransaksiId);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Detail transaksi deleted successfully' : 'Failed to delete detail transaksi'
        ]);
    }

    // public function deleteDetailTransaksi(Faktur $faktur, $detailTransaksiId)
    // {
    //     $detailTransaksi = DetailTransaksi::where('faktur_id', $faktur->id)
    //         ->where('id', $detailTransaksiId)
    //         ->firstOrFail();

    //     $this->fakturService->deleteDetailTransaksi($detailTransaksi);

    //     return response()->json([
    //         'message' => 'Detail transaksi deleted successfully'
    //     ]);
    // }

    /**
     * Add a detail transaksi to a faktur.
     */
    public function addDetailTransaksi(Request $request, Assignment $assignment, Sistem $sistem, Faktur $faktur)
    {
        // For personal accounts, check if they're representing a company
        $representedCompanyId = $request->input('company_id');
        $representedCompany = null;

        if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
            $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

            // Check if this personal account can represent the company
            if (!$this->permissionService->canPerformFakturAction($sistem, 'update', $representedCompany)) {
                return response()->json(['message' => 'You cannot represent this company'], 403);
            }

            // Check if the faktur belongs to the represented company
            if ($faktur->akun_pengirim_id !== $representedCompany->id) {
                return response()->json(['message' => 'Faktur not found for this company'], 404);
            }
        } else {
            // Check if the faktur belongs to the current sistem
            if ($faktur->akun_pengirim_id !== $sistem->id) {
                return response()->json(['message' => 'Faktur not found'], 404);
            }
        }

        // Only draft fakturs can be updated
        if ($faktur->status !== 'draft') {
            return response()->json(['message' => 'Only draft fakturs can be updated'], 400);
        }

        $data = array_merge($request->all(), ['faktur_id' => $faktur->id]);
        $detailTransaksi = $this->fakturService->addDetailTransaksi($faktur, $data);

        return response()->json([
            'message' => 'Detail transaksi added successfully',
            'data' => $detailTransaksi
        ]);
    }

    // public function addDetailTransaksi(Faktur $faktur, StoreDetailTransaksiRequest $request)
    // {

    //     $detailTransaksi = $this->fakturService->addDetailTransaksi($faktur, $request->validated());

    //     return response()->json([
    //         'message' => 'Detail transaksi added successfully',
    //         'data' => $detailTransaksi
    //     ], 201);
    // }

        // public function update(Request $request, Assignment $assignment, Sistem $sistem, Faktur $faktur)
    // {
    //     // For personal accounts, check if they're representing a company
    //     $representedCompanyId = $request->input('company_id');
    //     $representedCompany = null;

    //     if ($representedCompanyId && $sistem->tipe_akun === 'Orang Pribadi') {
    //         $representedCompany = Sistem::findOrFail($representedCompanyId)->first();

    //         // Check if this personal account can represent the company
    //         if (!$this->permissionService->canPerformFakturAction($sistem, 'update', $representedCompany)) {
    //             return response()->json(['message' => 'You cannot represent this company'], 403);
    //         }

    //         // Check if the faktur belongs to the represented company
    //         if ($faktur->akun_pengirim_id !== $representedCompany->id) {
    //             return response()->json(['message' => 'Faktur not found for this company'], 404);
    //         }
    //     } else {
    //         // Check if the faktur belongs to the current sistem
    //         if ($faktur->akun_pengirim_id !== $sistem->id) {
    //             return response()->json(['message' => 'Faktur not found'], 404);
    //         }
    //     }

    //     // Only draft fakturs can be updated
    //     if ($faktur->status !== 'draft') {
    //         return response()->json(['message' => 'Only draft fakturs can be updated'], 400);
    //     }

    //     $updatedFaktur = $this->fakturService->update($faktur, $request->all());

    //     return new FakturResource($updatedFaktur);
    // }

    // public function update(Assignment $assignment, Sistem $sistem, UpdateFakturRequest $request, Faktur $faktur) {
    //     $this->fakturService->getAllForSistem($assignment, $sistem, new Request(), 1);

    //     $updatedFaktur = $this->fakturService->update($faktur, $request->validated());
    //     $updatedFaktur->load('detail_transaksis');
    //     return new FakturResource($updatedFaktur);
    // }

    // public function deleteDetailTransaksi(Faktur $faktur, $detailTransaksiId)
    // {
    //     $detailTransaksi = DetailTransaksi::where('faktur_id', $faktur->id)
    //         ->where('id', $detailTransaksiId)
    //         ->firstOrFail();

    //     $this->fakturService->deleteDetailTransaksi($detailTransaksi);

    //     return response()->json([
    //         'success' => $result,
    //         'message' => $result ? 'Faktur deleted successfully' : 'Failed to delete faktur'
    //     ]);
    // }
    // public function destroy(Assignment $assignment, Sistem $sistem, Request $request, Faktur $faktur)
    // {
    //     return $this->fakturService->delete($faktur);
    // }

    /**
     * Delete a detail transaksi from a faktur.
     */
}
