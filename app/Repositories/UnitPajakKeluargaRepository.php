<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\UnitPajakKeluarga;
use App\Support\Interfaces\Repositories\UnitPajakKeluargaRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UnitPajakKeluargaRepository extends BaseRepository implements UnitPajakKeluargaRepositoryInterface
{
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    /**
     * Get the model class
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return UnitPajakKeluarga::class;
    }

    /**
     * Apply filters to the query
     *
     * @param array $searchParams
     * @return Builder
     */
    protected function applyFilters(array $searchParams = []): Builder
    {
        $query = $this->getQuery();

        // Apply search filters for UnitPajakKeluarga fields
        $query = $this->applySearchFilters($query, $searchParams, [
            'nik_anggota_keluarga',
            'nama_anggota_keluarga',
            'nomor_kartu_keluarga'
        ]);

        // Apply column filters
        $query = $this->applyColumnFilters($query, $searchParams, [
            'id',
            'sistem_id',
            'jenis_kelamin',
            'status_hubungan_keluarga',
            'status_unit_perpajakan',
            'status_ptkp'
        ]);

        // Explicitly handle sistem_id filtering if it exists in searchParams
        if (isset($searchParams['sistem_id'])) {
            $query->where('sistem_id', $searchParams['sistem_id']);
        }

        // Apply date range filters
        if (isset($searchParams['tanggal_lahir_from']) && isset($searchParams['tanggal_lahir_to'])) {
            $query->whereBetween('tanggal_lahir', [
                $searchParams['tanggal_lahir_from'],
                $searchParams['tanggal_lahir_to']
            ]);
        }

        if (isset($searchParams['tanggal_mulai_from']) && isset($searchParams['tanggal_mulai_to'])) {
            $query->whereBetween('tanggal_mulai', [
                $searchParams['tanggal_mulai_from'],
                $searchParams['tanggal_mulai_to']
            ]);
        }

        if (isset($searchParams['tanggal_berakhir_from']) && isset($searchParams['tanggal_berakhir_to'])) {
            $query->whereBetween('tanggal_berakhir', [
                $searchParams['tanggal_berakhir_from'],
                $searchParams['tanggal_berakhir_to']
            ]);
        }

        // Apply relations
        $query = $this->applyResolvedRelations($query, $searchParams);

        // Apply sorting
        $query = $this->applySorting($query, $searchParams);

        return $query;
    }

    /**
     * Get UnitPajakKeluarga by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * Get UnitPajakKeluarga by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->getQuery()->where('sistem_id', $sistemId)->get();
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
        $query = $this->getQuery()->where('nik_anggota_keluarga', 'like', "%{$nik}%");

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
        $query = $this->getQuery()->where('nama_anggota_keluarga', 'like', "%{$nama}%");

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
        $query = $this->getQuery()->where('status_hubungan_keluarga', $statusHubungan);

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
        $query = $this->getQuery()->where('nomor_kartu_keluarga', 'like', "%{$nomorKK}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
    }
}
