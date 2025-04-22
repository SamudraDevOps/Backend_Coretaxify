<?php

namespace App\Support\Interfaces\Services;

use App\Models\Pic;
use App\Models\Sistem;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\Contracts\BaseCrudServiceInterface;
use Illuminate\Support\Collection;

interface PicServiceInterface extends BaseCrudServiceInterface
{
    /**
     * Get all companies that a personal account represents
     */
    public function getRepresentedCompanies(Sistem $personal): Collection;

    /**
     * Get all personal accounts that represent a company
     */
    public function getCompanyRepresentatives(Sistem $company): Collection;

    /**
     * Check if a personal account can represent a company
     */
    public function canRepresent(Sistem $personal, Sistem $company): bool;

    /**
     * Assign a personal account as a representative for a company
     */
    public function assignRepresentative(Sistem $company, Sistem $personal): ?Pic;

    /**
     * Remove a personal account as a representative for a company
     */
    public function removeRepresentative(Sistem $company, Sistem $personal): bool;
}
