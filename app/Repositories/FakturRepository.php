<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\Faktur;
use App\Support\Interfaces\Repositories\FakturRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;

class FakturRepository extends BaseRepository implements FakturRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return Faktur::class;
    }

    protected function applyFilters(array $searchParams = []): Builder {
        $query = $this->getQuery();

        $query = $this->applySearchFilters($query, $searchParams, ['name']);

        $query = $this->applyColumnFilters($query, $searchParams, ['id']);

        $query = $this->applyResolvedRelations($query, $searchParams);

        $query = $this->applySorting($query, $searchParams);

        $query = $this->buildFilterQuery($query, $searchParams);

        return $query;
    }

    protected function buildFilterQuery(Builder $query, array $searchParams): Builder
    {
        if (isset($searchParams['akun_pengirim_id'])) {
            $query->where('akun_pengirim_id', $searchParams['akun_pengirim_id']);
        }

        if (isset($searchParams['akun_penerima_id'])) {
            $query->where('akun_penerima_id', $searchParams['akun_penerima_id']);
        }

        if (isset($searchParams['is_draft'])) {
            $query->where('is_draft', $searchParams['is_draft']);
        }

        return $query;
    }
}
