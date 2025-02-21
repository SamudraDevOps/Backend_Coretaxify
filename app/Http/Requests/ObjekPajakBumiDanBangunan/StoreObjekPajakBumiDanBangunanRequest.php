<?php

namespace App\Http\Requests\ObjekPajakBumiDanBangunan;

use Illuminate\Foundation\Http\FormRequest;

class StoreObjekPajakBumiDanBangunanRequest extends FormRequest {
    public function rules(): array {
        return [
            'profil_saya_id' => 'nullable|exists:profil_sayas,id', 
            'nop' => 'nullable|string',
            'nama_objek_pajak' => 'nullable|string',
            'sektor' => 'nullable|string',
            'jenis' => 'nullable|string',
            'tipe_bumi' => 'nullable|string',
            'rincian' => 'nullable|string',
            'status_kegiatan' => 'nullable|string',
            'instansi_pemberi_izin' => 'nullable|string',
            'luas_objek_pajak' => 'nullable|integer',
            'nomor_induk_berusaha' => 'nullable|integer',
            'tanggal_nomor_induk_berusaha' => 'nullable|date',
            'nomor_ijin_objek' => 'nullable|integer',
            'tanggal_ijin_objek' => 'nullable|date',
            'detail_alamat' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kota_kabupaten' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan_desa' => 'nullable|string',
            'kode_wilayah' => 'nullable|string',
            'kode_pos'  => 'nullable|string',
            'data_geometri' => 'nullable|string',
            'tanggal_pendaftaran' => 'nullable|date',
            'tanggal_pencabutan_pendaftaran' => 'nullable|date',
            'kode_kpp' => 'nullable|string',
            'seksi_pengawasan' => 'nullable|string',
        ];
    }
}