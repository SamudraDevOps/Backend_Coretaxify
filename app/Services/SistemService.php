<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Support\Interfaces\Repositories\SistemRepositoryInterface;
use App\Support\Interfaces\Services\SistemServiceInterface;
use Illuminate\Database\Eloquent\Model;

class SistemService extends BaseCrudService implements SistemServiceInterface {
    protected function getRepositoryClass(): string {
        return SistemRepositoryInterface::class;
    }
    
    public function create(array $data): ?Model {
        $data['assignment_user_id'] = $data['assignment_user_id'] ?? null;
        
        $sistem = parent::create($data);
        
        $portal = $sistem->portal_saya()->create();

        $sistem->update(['portal_saya_id' => $portal->id]);
                
        $profil = $portal->profil_saya()->create();

        $portal->update(['profil_saya_id' => $profil->id]);
                
        $informasi_umum         =    $profil->informasi_umum()->create();
        $alamat_pajak           =    $profil->alamat_pajak()->create();
        $kuasa_wajib_pajak      =    $profil->kuasa_wajib_pajak()->create();
        $manajemen_kasus        =    $profil->manajemen_kasus()->create();
        $detail_kontak          =    $profil->detail_kontak()->create();
        $kode_klu               =    $profil->kode_klu()->create();
        $tempat_kegiatan_usaha  =    $profil->tempat_kegiatan_usaha()->create();
        $alamat_wajib_pajak     =    $profil->alamat_wajib_pajak()->create();
        $pihak_terkait          =    $profil->pihak_terkait()->create();
        $data_ekonomi           =    $profil->data_ekonomi()->create();
        $nomor_identifikasi_eksternal       =     $profil->nomor_identifikasi_eksternal()->create();
        $jenis_pajak            =    $profil->jenis_pajak()->create();
        $objek_pajak_bumi_dan_bangunan      =        $profil->objek_pajak_bumi_dan_bangunan()->create();
        $detail_bank            =    $profil->detail_bank()->create();
        
        $profil->update([
            'informasi_umum_id' => $informasi_umum->id,
            'alamat_pajak_id' => $alamat_pajak->id,
            'kuasa_wajib_pajak_id' => $kuasa_wajib_pajak->id,
            'manajemen_kasus_id' => $manajemen_kasus->id,
            'detail_kontak_id' => $detail_kontak->id,
            'kode_klu_id' => $kode_klu->id,
            'tempat_kegiatan_usaha_id' => $tempat_kegiatan_usaha->id,
            'alamat_wajib_pajak_id' => $alamat_wajib_pajak->id,
            'pihak_terkait_id' => $pihak_terkait->id,
            'data_ekonomi_id' => $data_ekonomi->id,
            'nomor_identifikasi_eksternal_id' => $nomor_identifikasi_eksternal->id,
            'jenis_pajak_id' => $jenis_pajak->id,
            'objek_pajak_bumi_dan_bangunan_id' => $objek_pajak_bumi_dan_bangunan->id,
            'detail_bank_id' => $detail_bank->id,
        ]);
        
        return $sistem;
    }
}