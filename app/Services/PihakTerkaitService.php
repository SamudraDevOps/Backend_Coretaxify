<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\PihakTerkait;
use App\Models\Sistem;
use App\Models\Assignment;
use App\Models\Pic;
use App\Support\Enums\IntentEnum;
use Illuminate\Database\Eloquent\Collection;
use App\Support\Interfaces\Repositories\PihakTerkaitRepositoryInterface;
use App\Support\Interfaces\Services\PihakTerkaitServiceInterface;

class PihakTerkaitService extends BaseCrudService implements PihakTerkaitServiceInterface {
    protected function getRepositoryClass(): string {
        return PihakTerkaitRepositoryInterface::class;
    }

    public function create(array $data , ?Sistem $sistem = null): ?Model {
        // dd($data);
        // $intent = $data['intent'];
        $randomNumber = 'DA' . mt_rand(10000000, 99999999);

        $pihakTerkait = PihakTerkait::create([
            'akun_id' => $data['akun_id'],
            'nama_pengurus' => $data['nama_pengurus'],
            'npwp' => $data['npwp'],
            'kewarganegaraan' => $data['kewarganegaraan'],
            'negara_asal' => $data['negara_asal'],
            'sub_orang_terkait' => $data['sub_orang_terkait'],
            'email' => $data['email'],
            'keterangan' => $data['keterangan'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_berakhir' => $data['tanggal_berakhir'],
            'id_penunjukkan_perwakilan' => $randomNumber,
            'sistem_id' => $sistem->id,
        ]);

        $idAkunOp = $data['akun_id'];

        Pic::create([
            'assignment_user_id' => $sistem->assignment_user_id,
            'akun_op_id' => $idAkunOp,
            'akun_badan_id' => $sistem->id,
        ]);

        return $pihakTerkait;
    }

    public function getAllBySistemId(array $filters, int $sistemId): Collection
    {
        $repository = $this->repository; 

        return $repository->getAllBySistemId($filters, $sistemId);
    }
}
