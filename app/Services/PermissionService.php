<?php

namespace App\Services;

use App\Models\Pic;
use App\Models\Sistem;
use App\Support\Interfaces\Services\PermissionServiceInterface;

class PermissionService implements PermissionServiceInterface
{
    /**
     * Check if an account can perform a specific faktur action
     */
    public function canPerformFakturAction(Sistem $sistem, string $action, ?Sistem $representedCompany = null): bool
    {
        // Company accounts can perform all actions directly
        if ($sistem->tipe_akun === 'Badan' || $sistem->tipe_akun === 'Badan Lawan Transaksi') {
            return true;
        }

        // Personal accounts need to represent a company
        if ($sistem->tipe_akun === 'Orang Pribadi' && $representedCompany) {
            // Check if this personal account represents the company
            return Pic::where('akun_op_id', $sistem->id)
                ->where('akun_badan_id', $representedCompany->id)
                ->where('assignment_user_id', $sistem->assignment_user_id)
                ->exists();
        }

        return false;
    }

    /**
     * Get the effective account to use (original or represented company)
     */
    public function getEffectiveAccount(Sistem $sistem, ?Sistem $representedCompany = null): Sistem
    {
        // For company accounts, use the account directly
        if ($sistem->tipe_akun === 'Badan' || $sistem->tipe_akun === 'Badan Lawan Transaksi') {
            return $sistem;
        }

        // For personal accounts representing a company, use the company
        if ($sistem->tipe_akun === 'Orang Pribadi' && $representedCompany) {
            $canRepresent = Pic::where('akun_op_id', $sistem->id)
                ->where('akun_badan_id', $representedCompany->id)
                ->where('assignment_user_id', $sistem->assignment_user_id)
                ->exists();

            if ($canRepresent) {
                return $representedCompany;
            }
        }

        // Default to the original account
        return $sistem;
    }
}
