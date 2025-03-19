<?php

namespace App\Http\Controllers\Api;

use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\DetailBank;
use Illuminate\Http\Request;
use App\Models\AssignmentUser;
use App\Http\Resources\DetailBankResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\DetailBank\StoreDetailBankRequest;
use App\Http\Requests\DetailBank\UpdateDetailBankRequest;
use App\Support\Interfaces\Services\DetailBankServiceInterface;

class ApiDetailBankController extends ApiController {
    public function __construct(
        protected DetailBankServiceInterface $detailBankService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Assignment $assignment, Sistem $sistem, Request $request) {
        $perPage = request()->get('perPage', 5);

        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403);
        }

        Sistem::where('assignment_user_id', $assignmentUser->id)
                ->where('id', $sistem->id)
                ->firstOrFail();



        $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);

        return DetailBankResource::collection($this->detailBankService->getAllPaginated($filters, $perPage));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Assignment $assignment, Sistem $sistem, StoreDetailBankRequest $request) {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403);
        }

        Sistem::where('assignment_user_id', $assignmentUser->id)
                ->where('id', $sistem->id)
                ->firstOrFail();

        return $this->detailBankService->create($request->validated(), $sistem);
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment, Sistem $sistem, DetailBank $detailBank) {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403);
        }

        Sistem::where('assignment_user_id', $assignmentUser->id)
                ->where('id', $sistem->id)
                ->firstOrFail();

        if ($detailBank->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses punyak siapa.');
        }

        return new DetailBankResource($detailBank);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Assignment $assignment, Sistem $sistem, UpdateDetailBankRequest $request, DetailBank $detailBank) {
        $assignmentUser = AssignmentUser::where([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403);
        }

        Sistem::where('assignment_user_id', $assignmentUser->id)
                ->where('id', $sistem->id)
                ->firstOrFail();

        if ($detailBank->sistem_id !== $sistem->id) {
        abort(403, 'hayo ngakses detail kontak punyak siapa.');
        }

        return $this->detailBankService->update($detailBank, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DetailBank $detailBank) {
        return $this->detailBankService->delete($detailBank);
    }
}
