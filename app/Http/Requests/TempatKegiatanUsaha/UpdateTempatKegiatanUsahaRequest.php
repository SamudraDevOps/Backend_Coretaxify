<?php

namespace App\Http\Requests\TempatKegiatanUsaha;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTempatKegiatanUsahaRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'nitku' => 'nullable|string',
            'jenis_tku' => 'nullable|string',
            'nama_tku' => 'nullable|string',
            'deskripsi_tku' => 'nullable|string',
            'nama_klu' => 'nullable|string',
            'deskripsi_klu' => 'nullable|string',
            'tambah_pic_tku_id' => 'nullable|string',
            'jenis_alamat' => 'nullable|string',
            'detail_alamat' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kota_kabupaten' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kelurahan_desa' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'data_geometri' => 'nullable|string',
            'seksi_pengawasan' => 'nullable|string',
            'is_lokasi_yang_disewa' => 'nullable|boolean',
            'tanggal_dimulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'is_toko_retail' => 'nullable|boolean',
            'is_kawasan_bebas' => 'nullable|boolean',
            'is_kawasan_ekonomi_khusus' => 'nullable|boolean',
            'is_tempat_penimbunan_berikat' => 'nullable|boolean',
            'nomor_surat_keputusan' => 'nullable|string',
            'decree_number_data_valid_from' => 'nullable|date',
            'decree_number_data_valid_to' => 'nullable|date',
            'kode_kpp' => 'nullable|string',
            'is_alamat_utama_pkp' => 'nullable|boolean',
        ];
    }
}