<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\Sistem;
use App\Models\TempatKegiatanUsaha;
use App\Support\Interfaces\Repositories\TempatKegiatanUsahaRepositoryInterface;
use App\Support\Interfaces\Services\TempatKegiatanUsahaServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TempatKegiatanUsahaService extends BaseCrudService implements TempatKegiatanUsahaServiceInterface
{
    /**
     * Get the repository class
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return TempatKegiatanUsahaRepositoryInterface::class;
    }

    /**
     * Create a new TempatKegiatanUsaha
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model
    {
        $createData = [
            'nitku' => $data['nitku'],
            'jenis_tku' => $data['jenis_tku'],
            'nama_tku' => $data['nama_tku'],
            'jenis_usaha' => $data['jenis_usaha'],
        ];

        if ($sistem) {
            $createData['sistem_id'] = $sistem->id;
        }

        return $this->repository->create($createData);
    }

    /**
     * Get TempatKegiatanUsaha by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * Get TempatKegiatanUsaha by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->repository->findWhere(['sistem_id' => $sistemId]);
    }

    /**
     * Get TempatKegiatanUsaha by NITKU
     *
     * @param string $nitku
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByNitku(string $nitku, ?int $sistemId = null): Collection
    {
        $criteria = ['nitku' => $nitku];

        if ($sistemId) {
            $criteria['sistem_id'] = $sistemId;
        }

        return $this->repository->findWhere($criteria);
    }

    /**
     * Get TempatKegiatanUsaha by jenis TKU
     *
     * @param string $jenisTku
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisTku(string $jenisTku, ?int $sistemId = null): Collection
    {
        $criteria = ['jenis_tku' => $jenisTku];

        if ($sistemId) {
            $criteria['sistem_id'] = $sistemId;
        }

        return $this->repository->findWhere($criteria);
    }

    /**
     * Get TempatKegiatanUsaha by nama TKU
     *
     * @param string $namaTku
     * @param int|null $sistemId
     * @return Collection
     */
    // public function getByNamaTku(string $namaTku, ?int $sistemId = null): Collection
    // {
    //     // Using a custom query since we need a LIKE operation
    //     $query = $this->repository->getQuery()->where('nama_tku', 'like', "%{$namaTku}%");

    //     if ($sistemId) {
    //         $query->where('sistem_id', $sistemId);
    //     }

    //     return $query->get();
    // }

    /**
     * Get all TempatKegiatanUsaha for a Sistem with pagination
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
        $this->authorizeAccess($assignment, $sistem);

        $filters = array_merge($request->query(), ['sistem_id' => $sistem->id]);

        return $this->getAllPaginated($filters, $perPage);
    }

    /**
     * Get TempatKegiatanUsaha detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @return Model|null
     */
    public function getTempatKegiatanUsahaDetail(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha
    ): ?Model {
        $this->authorizeAccessToTempatKegiatanUsaha($assignment, $sistem, $tempatKegiatanUsaha);

        return $tempatKegiatanUsaha;
    }

    /**
     * Update TempatKegiatanUsaha with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @param array $data
     * @return Model|null
     */
    public function updateTempatKegiatanUsaha(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha,
        array $data
    ): ?Model {
        $this->authorizeAccessToTempatKegiatanUsaha($assignment, $sistem, $tempatKegiatanUsaha);

        return $this->update($tempatKegiatanUsaha, $data);
    }

    /**
     * Delete TempatKegiatanUsaha with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @return bool
     */
    public function deleteTempatKegiatanUsaha(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha
    ): bool {
        $this->authorizeAccessToTempatKegiatanUsaha($assignment, $sistem, $tempatKegiatanUsaha);

        return $this->delete($tempatKegiatanUsaha);
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
     * Authorize access to the tempat kegiatan usaha
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param TempatKegiatanUsaha $tempatKegiatanUsaha
     * @return void
     */
    private function authorizeAccessToTempatKegiatanUsaha(
        Assignment $assignment,
        Sistem $sistem,
        TempatKegiatanUsaha $tempatKegiatanUsaha
    ): void {
        $this->authorizeAccess($assignment, $sistem);

        // Ensure the tempat kegiatan usaha belongs to the specified sistem
        if ($tempatKegiatanUsaha->sistem_id !== $sistem->id) {
            abort(403, 'Unauthorized access to this tempat kegiatan usaha');
        }
    }
}
