<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\PihakTerkait;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\Pic;
use App\Models\AssignmentUser;
use App\Support\Enums\IntentEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\Interfaces\Repositories\PihakTerkaitRepositoryInterface;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;

class PihakTerkaitService extends BaseCrudService implements PihakTerkaitServiceInterface {
    protected function getRepositoryClass(): string {
        return PihakTerkaitRepositoryInterface::class;
    }

    public function create(array $data , ?Sistem $sistem = null): ?Model {
        // dd($data);
        // $intent = $data['intent'];
        $randomNumber = 'DA' . mt_rand(10000000, 99999999);

        $pihakTerkait = PihakTerkait::create([
            'akun_op' => $data['akun_op'],
            'kewarganegaraan' => $data['kewarganegaraan'],
            'negara_asal' => $data['negara_asal'],
            'sub_orang_terkait' => $data['sub_orang_terkait'],
            'keterangan' => $data['keterangan'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'id_penunjukkan_perwakilan' => $randomNumber,
            'sistem_id' => $sistem->id,
        ]);

        $idAkunOp = $data['akun_op'];

        Pic::create([
            'assignment_user_id' => $sistem->assignment_user_id,
            'akun_op_id' => $idAkunOp,
            'akun_badan_id' => $sistem->id,
        ]);

        return $pihakTerkait;
    }

    public function getAllBySistemId(array $filters, int $sistemId): Collection
    {
        return $this->repository->getAllBySistemId($filters, $sistemId);
    }

    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    ) {
        $this->authorizeAccess($assignment, $sistem);

        $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);

        return $this->getAllPaginated($filters, $perPage);
    }

    /**
     * Get PihakTerkait detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @return Model|null
     */
    public function getPihakTerkaitDetail(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait
    ): ?Model {
        $this->authorizeAccessToPihakTerkait($assignment, $sistem, $pihakTerkait);

        return $pihakTerkait;
    }

    /**
     * Update PihakTerkait with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @param array $data
     * @return Model|null
     */
    public function updatePihakTerkait(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait,
        array $data
    ): ?Model {
        $this->authorizeAccessToPihakTerkait($assignment, $sistem, $pihakTerkait);

        return $this->update($pihakTerkait, $data);
    }

    /**
     * Delete PihakTerkait with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @return bool
     */
    public function deletePihakTerkait(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait
    ): bool {
        $this->authorizeAccessToPihakTerkait($assignment, $sistem, $pihakTerkait);

        // Also delete related PIC records if needed
        Pic::where('akun_op_id', $pihakTerkait->akun_op)
            ->where('akun_badan_id', $sistem->id)
            ->delete();

        return $this->delete($pihakTerkait);
    }

    /**
     * Authorize access to the sistem
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @return void
     */
    private function authorizeAccess(Assignment $assignment, Sistem $sistem): void
    {
        $assignmentUser = AssignmentUser::where([
            'user_id' => Auth::id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if ($sistem->assignment_user_id !== $assignmentUser->id) {
            abort(403, 'Unauthorized access to this sistem');
        }
        // Verify the sistem exists for this assignment user
        Sistem::where('assignment_user_id', $assignmentUser->id)
        ->where('id', $sistem->id)
        ->firstOrFail();
    }

    /**
     * Authorize access to the pihak terkait
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param PihakTerkait $pihakTerkait
     * @return void
     */
    private function authorizeAccessToPihakTerkait(
        Assignment $assignment,
        Sistem $sistem,
        PihakTerkait $pihakTerkait
        ): void {
            $this->authorizeAccess($assignment, $sistem);

            // return 123;
            // Ensure the pihak terkait belongs to the specified sistem
        if ($pihakTerkait->sistem_id !== $sistem->id) {
            abort(403, 'Unauthorized access to this pihak terkait');
        }
    }
}
