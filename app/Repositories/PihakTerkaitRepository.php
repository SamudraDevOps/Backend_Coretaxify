<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\PihakTerkait;
use App\Support\Interfaces\Repositories\PihakTerkaitRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PihakTerkaitRepository extends BaseRepository implements PihakTerkaitRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return PihakTerkait::class;
    }

    protected function applyFilters(array $searchParams = []): Builder {
        $query = $this->getQuery();

        $query = $this->applySearchFilters($query, $searchParams, [
            'nama_pengurus',
            'npwp',
            'email',
            'keterangan'
        ]);

        // Apply column filters
        $query = $this->applyColumnFilters($query, $searchParams, [
            'id',
            'sistem_id',
            'akun_id',
            'kewarganegaraan',
            'negara_asal',
            'sub_orang_terkait'
        ]);

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

    public function getAllBySistemId(array $filters, int $sistemId): Collection
    {
        $query = $this->applyFilters($filters);
        $query->where('sistem_id', $sistemId);

        return $query->get();
    }
}
