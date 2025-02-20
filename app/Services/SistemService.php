<?php

namespace App\Services;

use Adobrovolsky97\LaravelRepositoryServicePattern\Services\BaseCrudService;
use App\Models\AlamatWajibPajak;
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
use App\Models\PihakTerkait;
use App\Models\PortalSaya;
use App\Models\ProfilSaya;
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
        $sistem = parent::create($data);
        
        $portal = PortalSaya::create();

        $sistem->update(['portal_saya_id' => $portal->id]);
                
        $profil = ProfilSaya::create();

        $portal->update(['profil_saya_id' => $profil->id]);
                
        $informasi_umum         =    InformasiUmum::create();
        $alamat_pajak           =    AlamatWajibPajak::create();
        $kuasa_wajib_pajak      =    KuasaWajibPajak::create();
        $manajemen_kasus        =    ManajemenKasus::create();
        $detail_kontak          =    DetailKontak::create();
        $kode_klu               =    KodeKlu::create();
        $tempat_kegiatan_usaha  =    TempatKegiatanUsaha::create();
        $pihak_terkait          =    PihakTerkait::create();
        $data_ekonomi           =    DataEkonomi::create();
        $nomor_identifikasi_eksternal       =     NomorIdentifikasiEksternal::create();
        $jenis_pajak            =    JenisPajak::create();
        $objek_pajak_bumi_dan_bangunan      =        ObjekPajakBumiDanBangunan::create();
        $detail_bank            =    DetailBank::create();
        $alamat_wajib_pajak      =   AlamatWajibPajak::create();
        
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