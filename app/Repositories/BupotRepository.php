<?php

namespace App\Repositories;

use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;
use App\Models\Bupot;
use App\Support\Interfaces\Repositories\BupotRepositoryInterface;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Traits\Repositories\HandlesSorting;
use Illuminate\Database\Eloquent\Builder;

class BupotRepository extends BaseRepository implements BupotRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return Bupot::class;
    }

    protected function applyFilters(array $searchParams = []): Builder {
        $query = $this->getQuery();

        $query = $this->applySearchFilters($query, $searchParams, ['nomor_pemotongan']);

        $query = $this->applyColumnFilters($query, $searchParams, ['id', 'pembuat_id', 'tipe_bupot', 'status', 'status_penerbitan']);

        $query = $this->applyResolvedRelations($query, $searchParams);

        $query = $this->applySorting($query, $searchParams);

        return $query;
    }
}
