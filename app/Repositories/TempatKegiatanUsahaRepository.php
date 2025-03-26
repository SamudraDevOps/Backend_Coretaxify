<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\TempatKegiatanUsaha;
use App\Support\Interfaces\Repositories\TempatKegiatanUsahaRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TempatKegiatanUsahaRepository extends BaseRepository implements TempatKegiatanUsahaRepositoryInterface
{
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    /**
     * Get the model class
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return TempatKegiatanUsaha::class;
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

        // Apply search filters for TKU fields
        $query = $this->applySearchFilters($query, $searchParams, [
            'nitku',
            'nama_tku',
            'jenis_usaha'
        ]);

        // Apply column filters
        $query = $this->applyColumnFilters($query, $searchParams, ['id', 'sistem_id', 'jenis_tku']);

        // Explicitly handle sistem_id filtering if it exists in searchParams
        if (isset($searchParams['sistem_id'])) {
            $query->where('sistem_id', $searchParams['sistem_id']);
        }

        // Apply date range filters
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
     * Get TempatKegiatanUsaha by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * Get TempatKegiatanUsaha by Sistem ID
     *
     * @param int $sistemId
     * @return Collection
     */
    public function getBySistemId(int $sistemId): Collection
    {
        return $this->getQuery()->where('sistem_id', $sistemId)->get();
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
        $query = $this->getQuery()->where('nitku', 'like', "%{$nitku}%");

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
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
        $query = $this->getQuery()->where('jenis_tku', $jenisTku);

        if ($sistemId) {
            $query->where('sistem_id', $sistemId);
        }

        return $query->get();
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
    //     $query = $this->getQuery()->where('nama_tku', 'like', "%{$namaTku}%");

    //     if ($sistemId) {
    //         $query->where('sistem_id', $sistemId);
    //     }

    //     return $query->get();
    // }
}
