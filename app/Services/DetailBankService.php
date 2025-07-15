<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\DetailBank;
use App\Models\Sistem;
use App\Support\Interfaces\Repositories\DetailBankRepositoryInterface;
use App\Support\Interfaces\Services\DetailBankServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailBankService extends BaseCrudService implements DetailBankServiceInterface
{
    /**
     * Get the repository class
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return DetailBankRepositoryInterface::class;
    }

    /**
     * Create a new DetailBank
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model
    {
        $createData = [
            'nama_bank' => $data['nama_bank'],
            'nama_pemilik_bank' => $data['nama_pemilik_bank'],
            'nomor_rekening_bank' => $data['nomor_rekening_bank'],
            'jenis_rekening_bank' => $data['jenis_rekening_bank'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
        ];

        if ($sistem) {
            $createData['sistem_id'] = $sistem->id;
        }

        return $this->repository->create($createData);
    }

    /**
     * Get DetailBank by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->repository->getById($id);
    }

    /**
     * Get DetailBank by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->repository->getBySistemId($sistemId);
    }

    /**
     * Get DetailBank by nama bank
     *
     * @param string $namaBank
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNamaBank(string $namaBank, ?int $sistemId = null): Collection
    {
        return $this->repository->getByNamaBank($namaBank, $sistemId);
    }

    /**
     * Get DetailBank by nomor rekening
     *
     * @param string $nomorRekening
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNomorRekening(string $nomorRekening, ?int $sistemId = null): Collection
    {
        return $this->repository->getByNomorRekening($nomorRekening, $sistemId);
    }

    /**
     * Get DetailBank by jenis rekening
     *
     * @param string $jenisRekening
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisRekening(string $jenisRekening, ?int $sistemId = null): Collection
    {
        return $this->repository->getByJenisRekening($jenisRekening, $sistemId);
    }

    /**
     * Get all DetailBank for a Sistem with pagination
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param Request $request
     * @param int $perPage
     * @return mixed
     */
    public function getAllForSistem(
        Assignment $assignment,
        Sistem $sistem,
        Request $request,
        int $perPage = 5
    ) {
        $this->authorizeAccess($assignment, $sistem, $request);

        $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);

        return $this->getAllPaginated($filters, $perPage);
    }

    /**
     * Get DetailBank detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return Model|null
     */
        /**
     * Get DetailBank detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return Model|null
     */
    public function getDetailBankDetail(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank,
        Request $request
    ): ?Model {
        $this->authorizeAccessToDetailBank($assignment, $sistem, $detailBank, $request);

        return $detailBank;
    }

    /**
     * Update DetailBank with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @param array $data
     * @return Model|null
     */
    public function updateDetailBank(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank,
        array $data,
        Request $request
    ): ?Model {
        $this->authorizeAccessToDetailBank($assignment, $sistem, $detailBank, $request);

        return $this->update($detailBank, $data);
    }

    /**
     * Delete DetailBank with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return bool
     */
    public function deleteDetailBank(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank,
        Request $request
    ): bool {
        $this->authorizeAccessToDetailBank($assignment, $sistem, $detailBank, $request);

        return $this->delete($detailBank);
    }

    /**
     * Authorize access to the sistem
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @return void
     */
    private function authorizeAccess(Assignment $assignment, Sistem $sistem, Request $request): void
    {
        $user_id = $request->get('user_id');
        $assignmentUser = AssignmentUser::where([
            'user_id' => $user_id ?? auth()->id(),
            'assignment_id' => $assignment->id
        ])->firstOrFail();

        if (($sistem->assignment_user_id !== $assignmentUser->id) && !$user_id) {
            abort(403, 'Unauthorized access to this sistem');
        }

        // Verify the sistem exists for this assignment user
        Sistem::where('assignment_user_id', $assignmentUser->id)
            ->where('id', $sistem->id)
            ->firstOrFail();
    }

    /**
     * Authorize access to the detail bank
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailBank $detailBank
     * @return void
     */
    private function authorizeAccessToDetailBank(
        Assignment $assignment,
        Sistem $sistem,
        DetailBank $detailBank,
        Request $request
    ): void {
        $this->authorizeAccess($assignment, $sistem, $request);
        $user_id = $request->get('user_id');
        // Ensure the detail bank belongs to the specified sistem
        if (($detailBank->sistem_id !== $sistem->id) && !$user_id) {
            abort(403, 'Unauthorized access to this detail bank');
        }
    }
}
