<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\Account;
use App\Models\AlamatWajibPajak;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\ContractTask;
use App\Models\DataEkonomi;
use App\Models\DetailBank;
use App\Models\DetailKontak;
use App\Models\InformasiUmum;
use App\Models\JenisPajak;
use App\Models\KodeKlu;
use App\Models\KuasaWajibPajak;
use App\Models\ManajemenKasus;
use App\Models\NomorIdentifikasiEksternal;
use App\Models\ObjekPajakBumiDanBangunan;
use App\Models\PenunjukkanWajibPajakSaya;
use App\Models\PihakTerkait;
use App\Models\PortalSaya;
use App\Models\ProfilSaya;
use App\Models\Sistem;
use App\Models\Task;
use App\Models\TempatKegiatanUsaha;
use App\Support\Interfaces\Repositories\SistemRepositoryInterface;
use App\Support\Interfaces\Services\SistemServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class SistemService extends BaseCrudService implements SistemServiceInterface {
    protected function getRepositoryClass(): string {
        return SistemRepositoryInterface::class;
    }
    
    public function create(array $data): ?Model { 
        $dataAssignUserId = $data['assignment_user_id'];
        
        $assignUser_id = AssignmentUser::where('id', $dataAssignUserId)
                        ->first()->assignment_id;

        $task_id = Assignment::where('id', $assignUser_id)->first()->task_id;
        
        $dataAccount = Account::where('task_id', $task_id)
                    ->select('nama', 'npwp')
                    ->get();
        
        foreach($dataAccount as $account) {
            $sistem = parent::create([
                'assignment_user_id' => $dataAssignUserId,
                'nama_akun' => $account->nama,
                'npwp_akun' => $account->npwp
            ]);

            $portal = PortalSaya::create();
            $portal->update(['sistem_id' => $sistem->id]);
                    
            $profil = ProfilSaya::create();
            $profil->update(['portal_saya_id' => $portal->id]);
                    
            InformasiUmum::create([
                'profil_saya_id' => $profil->id
            ]);
            
            AlamatWajibPajak::create([
                'profil_saya_id' => $profil->id
            ]);
            
            KuasaWajibPajak::create([
                'profil_saya_id' => $profil->id
            ]);
            
            ManajemenKasus::create([
                'profil_saya_id' => $profil->id
            ]);
            
            DetailKontak::create([
                'profil_saya_id' => $profil->id
            ]);
            
            KodeKlu::create([
                'profil_saya_id' => $profil->id
            ]);
            
            TempatKegiatanUsaha::create([
                'profil_saya_id' => $profil->id
            ]);
            
            PihakTerkait::create([
                'profil_saya_id' => $profil->id
            ]);
            
            DataEkonomi::create([
                'profil_saya_id' => $profil->id
            ]);
            
            NomorIdentifikasiEksternal::create([
                'profil_saya_id' => $profil->id
            ]);
            
            JenisPajak::create([
                'profil_saya_id' => $profil->id
            ]);
            
            ObjekPajakBumiDanBangunan::create([
                'profil_saya_id' => $profil->id
            ]);
            
            DetailBank::create([
                'profil_saya_id' => $profil->id
            ]);
            
            AlamatWajibPajak::create([
                'profil_saya_id' => $profil->id
            ]);
            
            PenunjukkanWajibPajakSaya::create([
                'profil_saya_id' => $profil->id
            ]);
            
            
        }
                
        return $sistem;
    }
}