<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\DetailKontak;
use App\Models\Sistem;
use App\Support\Interfaces\Repositories\DetailKontakRepositoryInterface;
use App\Support\Interfaces\Services\DetailKontakServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailKontakService extends BaseCrudService implements DetailKontakServiceInterface
{
    /**
     * Get the repository class
     *
     * @return string
     */
    protected function getRepositoryClass(): string
    {
        return DetailKontakRepositoryInterface::class;
    }

    /**
     * Get repository instance
     *
     * @return DetailKontakRepositoryInterface
     */
    protected function getRepository(): DetailKontakRepositoryInterface
    {
        return app($this->getRepositoryClass());
    }

    /**
     * Create a new DetailKontak
     *
     * @param array $data
     * @param Sistem|null $sistem
     * @return Model|null
     */
    public function create(array $data, ?Sistem $sistem = null): ?Model
    {
        $createData = [
            'jenis_kontak' => $data['jenis_kontak'],
            'nomor_telpon' => $data['nomor_telpon'],
            'nomor_handphone' => $data['nomor_handphone'],
            'nomor_faksimile' => $data['nomor_faksimile'],
            'alamat_email' => $data['alamat_email'],
            'alamat_situs_wajib' => $data['alamat_situs_wajib'],
            'keterangan' => $data['keterangan'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
        ];

        if ($sistem) {
            $createData['sistem_id'] = $sistem->id;
        }

        return parent::create($createData);
    }

    /**
     * Get DetailKontak by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getRepository()->getById($id);
    }

    /**
     * Get DetailKontak by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->getRepository()->getBySistemId($sistemId);
    }

    /**
     * Get DetailKontak by jenis kontak
     *
     * @param string $jenisKontak
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByJenisKontak(string $jenisKontak, ?int $sistemId = null): Collection
    {
        return $this->getRepository()->getByJenisKontak($jenisKontak, $sistemId);
    }

    /**
     * Get DetailKontak by email
     *
     * @param string $email
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByEmail(string $email, ?int $sistemId = null): Collection
    {
        return $this->getRepository()->getByEmail($email, $sistemId);
    }

    /**
     * Get DetailKontak by phone number
     *
     * @param string $phoneNumber
     * @param int|null $sistemId
     * @return Collection
     */
    public function getByPhoneNumber(string $phoneNumber, ?int $sistemId = null): Collection
    {
        return $this->getRepository()->getByPhoneNumber($phoneNumber, $sistemId);
    }

    /**
     * Get all DetailKontak for a Sistem with pagination
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
     * Get DetailKontak detail with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return Model|null
     */
    public function getDetailKontakDetail(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        Request $request
    ): ?Model {
        $this->authorizeAccessToDetailKontak($assignment, $sistem, $detailKontak, $request);

        return $detailKontak;
    }

    /**
     * Update DetailKontak with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @param array $data
     * @return Model|null
     */
    public function updateDetailKontak(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        array $data,
        Request $request
    ): ?Model {
        $this->authorizeAccessToDetailKontak($assignment, $sistem, $detailKontak, $request);

        return $this->update($detailKontak, $data);
    }

    /**
     * Delete DetailKontak with authorization check
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return bool
     */
    public function deleteDetailKontak(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        Request $request
    ): bool {
        $this->authorizeAccessToDetailKontak($assignment, $sistem, $detailKontak, $request);

        return $this->delete($detailKontak);
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
     * Authorize access to the detail kontak
     *
     * @param Assignment $assignment
     * @param Sistem $sistem
     * @param DetailKontak $detailKontak
     * @return void
     */
    private function authorizeAccessToDetailKontak(
        Assignment $assignment,
        Sistem $sistem,
        DetailKontak $detailKontak,
        Request $request
    ): void {
        $this->authorizeAccess($assignment, $sistem, $request);
        $user_id = $request->get('user_id');
        // Ensure the detail kontak belongs to the specified sistem
        if (($detailKontak->sistem_id !== $sistem->id) && !$user_id) {
            abort(403, 'Unauthorized access to this detail kontak');
        }
    }
}
