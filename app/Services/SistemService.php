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
            
            $sistem->update(['portal_saya_id' => $portal->id]);
                    
            $profil = PortalSaya::create([
                'informasi_umum_id' => InformasiUmum::create()->id,
                'alamat_wajib_pajak_id' => AlamatWajibPajak::create()->id,
                'kuasa_wajib_pajak_id' => KuasaWajibPajak::create()->id,
                'manajemen_kasus_id' => ManajemenKasus::create()->id,
                'detail_kontak_id' => DetailKontak::create()->id,
                'kode_klu_id' => KodeKlu::create()->id,
                'tempat_kegiatan_usaha_id' => TempatKegiatanUsaha::create()->id,
                'pihak_terkait_id' => PihakTerkait::create()->id,
                'data_ekonomi_id' => DataEkonomi::create()->id,
                'nomor_identifikasi_eksternal_id' => NomorIdentifikasiEksternal::create()->id,
                'jenis_pajak_id' => JenisPajak::create()->id,
                'objek_pajak_bumi_dan_bangunan_id' => ObjekPajakBumiDanBangunan::create()->id,
                'detail_bank_id' => DetailBank::create()->id,
                'penunjukkan_wajib_pajak_saya_id' => PenunjukkanWajibPajakSaya::create()->id,
            ]);
            
            $portal->update(['profil_saya_id' => $profil->id]);
                    
            // $informasi_umum = InformasiUmum::create();
            
            // $alamatWajib =    AlamatWajibPajak::create();
                
            // $kuasawajib =    KuasaWajibPajak::create();
                
            // $manajemenaKasus =   ManajemenKasus::create();
                
            // $detailKontak =    DetailKontak::create();
                
            // $kodeKlu =    KodeKlu::create();
                
            // $tempatKegiatan =    TempatKegiatanUsaha::create();
                
            // $pihakTerkait =     PihakTerkait::create();
                
            // $dataEkonomi = DataEkonomi::create();
                
            // $nomorIdentifikasi = NomorIdentifikasiEksternal::create();
                
            // $jenisPajak = JenisPajak::create();
                
            // $objekPajak = ObjekPajakBumiDanBangunan::create();
                
            // $detailBank = DetailBank::create();
                
            // $alamatWajib = AlamatWajibPajak::create();
                
            // $penujukkanWajib = PenunjukkanWajibPajakSaya::create();
        }
                
        return $sistem;
    }
}