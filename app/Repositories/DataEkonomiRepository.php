<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\DataEkonomi;
use App\Support\Interfaces\Repositories\DataEkonomiRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DataEkonomiRepository extends BaseRepository implements DataEkonomiRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    /**
     * Get the model class
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        return DataEkonomi::class;
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

        // Apply search filters for merek_dagang
        $query = $this->applySearchFilters($query, $searchParams, ['merek_dagang']);

        // Apply column filters
        $query = $this->applyColumnFilters($query, $searchParams, [
            'id',
            'is_karyawan',
            'metode_pembukuan',
            'mata_uang_pembukuan'
        ]);

        // Apply range filters for numeric fields
        if (isset($searchParams['omset_min']) && isset($searchParams['omset_max'])) {
            $query->whereBetween('omset_per_tahun', [
                $searchParams['omset_min'],
                $searchParams['omset_max']
            ]);
        }

        if (isset($searchParams['jumlah_karyawan_min']) && isset($searchParams['jumlah_karyawan_max'])) {
            $query->whereBetween('jumlah_karyawan', [
                $searchParams['jumlah_karyawan_min'],
                $searchParams['jumlah_karyawan_max']
            ]);
        }

        // Apply relations
        $query = $this->applyResolvedRelations($query, $searchParams);

        // Apply sorting
        $query = $this->applySorting($query, $searchParams);

        return $query;
    }

    /**
     * Get DataEkonomi by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->getQuery()->where('id', $id)->first();
    }

    /**
     * Get DataEkonomi by merek dagang
     *
     * @param string $merekDagang
     * @return Collection
     */
    public function getByMerekDagang(string $merekDagang): Collection
    {
        return $this->getQuery()->where('merek_dagang', 'like', "%{$merekDagang}%")->get();
    }

    /**
     * Get DataEkonomi by omset range
     *
     * @param float $minOmset
     * @param float $maxOmset
     * @return Collection
     */
    public function getByOmsetRange(float $minOmset, float $maxOmset): Collection
    {
        return $this->getQuery()->whereBetween('omset_per_tahun', [$minOmset, $maxOmset])->get();
    }

    /**
     * Get DataEkonomi by employee status
     *
     * @param bool $isKaryawan
     * @return Collection
     */
    public function getByEmployeeStatus(bool $isKaryawan): Collection
    {
        return $this->getQuery()->where('is_karyawan', $isKaryawan)->get();
    }
}
