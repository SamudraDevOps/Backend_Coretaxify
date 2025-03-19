<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\DetailBankRepositoryInterface;
use App\Support\Interfaces\Services\DetailBankServiceInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistem;

class DetailBankService extends BaseCrudService implements DetailBankServiceInterface {
    protected function getRepositoryClass(): string {
        return DetailBankRepositoryInterface::class;
    }

    public function create(array $data, ?Sistem $sistem = null): ?Model{
        return $this->repository->create([
            'nama_bank' => $data['nama_bank'],
            'nomor_rekening_bank' => $data['nomor_rekening_bank'],
            'jenis_rekening_bank' => $data['jenis_rekening_bank'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'sistem_id' => $sistem->id,
        ]);
    }
}
