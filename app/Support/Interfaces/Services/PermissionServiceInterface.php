<?php

namespace App\Support\Interfaces\Services;

use App\Models\Sistem;

interface PermissionServiceInterface
{
    /**
     * Check if an account can perform a specific faktur action
     */
    public function canPerformFakturAction(Sistem $sistem, string $action, ?Sistem $representedCompany = null): bool;

    /**
     * Get the effective account to use (original or represented company)
     */
    public function getEffectiveAccount(Sistem $sistem, ?Sistem $representedCompany = null): Sistem;
}
