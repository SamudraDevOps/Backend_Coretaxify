<?php

namespace App\Services;

use App\Models\Pic;
use App\Models\Sistem;
use Illuminate\Support\Collection;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\PicRepositoryInterface;
use App\Support\Interfaces\Services\PicServiceInterface;

class PicService extends BaseCrudService implements PicServiceInterface
{
    protected function getRepositoryClass(): string
    {
        return PicRepositoryInterface::class;
    }

    /**
     * Get all companies that a personal account represents
     */
    public function getRepresentedCompanies(Sistem $personal): Collection
    {
        if ($personal->tipe_akun !== 'Orang Pribadi') {
            return collect([]);
        }

        $pics = Pic::where('akun_op_id', $personal->id)
                  ->where('assignment_user_id', $personal->assignment_user_id)
                  ->get();

        $companyIds = $pics->pluck('akun_badan_id')->toArray();

        return Sistem::whereIn('id', $companyIds)->get();
    }

    /**
     * Get all personal accounts that represent a company
     */
    public function getCompanyRepresentatives(Sistem $company): Collection
    {
        if ($company->tipe_akun !== 'Badan' && $company->tipe_akun !== 'Badan Lawan Transaksi') {
            return collect([]);
        }

        $pics = Pic::where('akun_badan_id', $company->id)
                  ->where('assignment_user_id', $company->assignment_user_id)
                  ->get();

        $personalIds = $pics->pluck('akun_op_id')->toArray();

        return Sistem::whereIn('id', $personalIds)->get();
    }

    /**
     * Check if a personal account can represent a company
     */
    public function canRepresent(Sistem $personal, Sistem $company): bool
    {
        if ($personal->tipe_akun !== 'Orang Pribadi' ||
            ($company->tipe_akun !== 'Badan' && $company->tipe_akun !== 'Badan Lawan Transaksi')) {
            return false;
        }

        if ($personal->assignment_user_id !== $company->assignment_user_id) {
            return false;
        }

        return Pic::where('akun_op_id', $personal->id)
                 ->where('akun_badan_id', $company->id)
                 ->where('assignment_user_id', $personal->assignment_user_id)
                 ->exists();
    }

    /**
     * Assign a personal account as a representative for a company
     */
    public function assignRepresentative(Sistem $company, Sistem $personal): ?Pic
    {
        if ($personal->tipe_akun !== 'Orang Pribadi' ||
            ($company->tipe_akun !== 'Badan' && $company->tipe_akun !== 'Badan Lawan Transaksi')) {
            return null;
        }

        if ($personal->assignment_user_id !== $company->assignment_user_id) {
            return null;
        }

        // Check if representation already exists
        $existing = Pic::where('akun_op_id', $personal->id)
                      ->where('akun_badan_id', $company->id)
                      ->where('assignment_user_id', $personal->assignment_user_id)
                      ->first();

        if ($existing) {
            return $existing;
        }

        // Create new representation
        return Pic::create([
            'akun_op_id' => $personal->id,
            'akun_badan_id' => $company->id,
            'assignment_user_id' => $personal->assignment_user_id
        ]);
    }

    /**
     * Remove a personal account as a representative for a company
     */
    public function removeRepresentative(Sistem $company, Sistem $personal): bool
    {
        if ($personal->tipe_akun !== 'Orang Pribadi' ||
            ($company->tipe_akun !== 'Badan' && $company->tipe_akun !== 'Badan Lawan Transaksi')) {
            return false;
        }

        return Pic::where('akun_op_id', $personal->id)
                 ->where('akun_badan_id', $company->id)
                 ->where('assignment_user_id', $personal->assignment_user_id)
                 ->delete() > 0;
    }
}
