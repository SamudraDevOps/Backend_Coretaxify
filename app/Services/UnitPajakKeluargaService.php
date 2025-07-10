<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\Sistem;
use App\Models\UnitPajakKeluarga;
use App\Support\Interfaces\Repositories\UnitPajakKeluargaRepositoryInterface;
use App\Support\Interfaces\Services\UnitPajakKeluargaServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitPajakKeluargaService extends BaseCrudService implements UnitPajakKeluargaServiceInterface
{
    /**
     * Get the repository class
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return UnitPajakKeluargaRepositoryInterface::class;
    }

    /**
     * Create a new UnitPajakKeluarga
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model
    {
        $createData = [
            'nik_anggota_keluarga' => $data['nik_anggota_keluarga'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'tempat_lahir' => $data['tempat_lahir'],
            'nomor_kartu_keluarga' => $data['nomor_kartu_keluarga'],
            'nama_anggota_keluarga' => $data['nama_anggota_keluarga'],
            'status_hubungan_keluarga' => $data['status_hubungan_keluarga'],
            'pekerjaan' => $data['pekerjaan'],
            'status_unit_perpajakan' => $data['status_unit_perpajakan'],
            'status_ptkp' => $data['status_ptkp'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
        ];

        if ($sistem) {
            $createData['sistem_id'] = $sistem->id;
        }

        return $this->repository->create($createData);
    }

    /**
     * Get UnitPajakKeluarga by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * Get UnitPajakKeluarga by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->repository->findWhere(['sistem_id' => $sistemId]);
    }

    /**
     * Get UnitPajakKeluarga by NIK
     *
     * @param string $nik
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNik(string $nik, ?int $sistemId = null): Collection
    {
        $query = $this->repository->getQuery()->where('nik_anggota_keluarga', 'like', "%{$nik}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get UnitPajakKeluarga by nama anggota keluarga
     *
     * @param string $nama
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNama(string $nama, ?int $sistemId = null): Collection
    {
        $query = $this->repository->getQuery()->where('nama_anggota_keluarga', 'like', "%{$nama}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get UnitPajakKeluarga by status hubungan keluarga
     *
     * @param string $statusHubungan
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByStatusHubungan(string $statusHubungan, ?int $sistemId = null): Collection
    {
        $query = $this->repository->getQuery()->where('status_hubungan_keluarga', $statusHubungan);

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get UnitPajakKeluarga by nomor kartu keluarga
     *
     * @param string $nomorKK
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNomorKK(string $nomorKK, ?int $sistemId = null): Collection
    {

        $query = $this->repository->getQuery()->where('nomor_kartu_keluarga', 'like', "%{$nomorKK}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }

    /**
     * Get all UnitPajakKeluarga for a Sistem with pagination
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
     * Get UnitPajakKeluarga detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @return Model|null
     */
    public function getUnitPajakKeluargaDetail(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga,
        Request $request
    ): ?Model {
        $this->authorizeAccessToUnitPajakKeluarga($assignment, $sistem, $unitPajakKeluarga, $request);

        return $unitPajakKeluarga;
    }

    /**
     * Update UnitPajakKeluarga with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @param array $data
     * @return Model|null
     */
    public function updateUnitPajakKeluarga(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga,
        array $data,
        Request $request
    ): ?Model {
        $this->authorizeAccessToUnitPajakKeluarga($assignment, $sistem, $unitPajakKeluarga, $request);

        return $this->update($unitPajakKeluarga, $data);
    }

    /**
     * Delete UnitPajakKeluarga with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @return bool
     */
    public function deleteUnitPajakKeluarga(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga,
        Request $request
    ): bool {
        $this->authorizeAccessToUnitPajakKeluarga($assignment, $sistem, $unitPajakKeluarga, $request);

        return $this->delete($unitPajakKeluarga);
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
     * Authorize access to the unit pajak keluarga
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param UnitPajakKeluarga $unitPajakKeluarga
     * @return void
     */
    private function authorizeAccessToUnitPajakKeluarga(
        Assignment $assignment,
        Sistem $sistem,
        UnitPajakKeluarga $unitPajakKeluarga,
        Request $request
    ): void {
        $this->authorizeAccess($assignment, $sistem, $request);
        $user_id = $request->get('user_id');
        // Ensure the unit pajak keluarga belongs to the specified sistem
        if (($unitPajakKeluarga->sistem_id !== $sistem->id) && !$user_id) {
            abort(403, 'Unauthorized access to this unit pajak keluarga');
        }
    }
}
