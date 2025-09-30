<?php

namespace App\Repositories;

use App\Models\User;
use App\Support\Enums\IntentEnum;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Repositories\HandlesSorting;
use App\Traits\Repositories\HandlesFiltering;
use App\Traits\Repositories\HandlesRelations;
use App\Support\Interfaces\Repositories\UserRepositoryInterface;
use Adobrovolsky97\LaravelRepositoryServicePattern\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface {
    use HandlesFiltering, HandlesRelations, HandlesSorting;

    protected function getModelClass(): string {
        return User::class;
    }

    protected function applyFilters(array $searchParams = []): Builder {
        $query = $this->getQuery();
        
        // $query = $this->applySearchFilters($query, $searchParams, ['name', 'email']);
        
        // $query = $this->applyColumnFilters($query, $searchParams, ['id', 'contract_id']);

        $query->where(function ($q) use ($searchParams) {
            $this->applySearchFilters($q, $searchParams, ['name', 'email']);
            $this->applyColumnFilters($q, $searchParams, ['id', 'contract_id']);
        });
        
        $query = $this->applyResolvedRelations($query, $searchParams);
        
        $query = $this->applySorting($query, $searchParams);

        if (isset($searchParams['intent'])) {
            $roleName = match ($searchParams['intent']) {
                IntentEnum::API_USER_GET_PSC->value => 'psc',
                IntentEnum::API_USER_GET_ADMIN->value => 'admin',
                IntentEnum::API_USER_GET_DOSEN->value => 'dosen',
                IntentEnum::API_USER_GET_MAHASISWA->value => 'mahasiswa',
                IntentEnum::API_USER_GET_MAHASISWA_PSC->value => 'mahasiswa-psc',
                IntentEnum::API_USER_GET_INSTRUKTUR->value => 'instruktur',
            };

            if ($roleName) {
                $query->whereHas('roles', function($q) use ($roleName) {
                    $q->where('name', $roleName);
                });
            }
        }
        
        return $query;
    }
}
