<?php

use App\Support\Enums\PTKPEnum;
use App\Support\Enums\GenderEnum;
use App\Support\Enums\BupotTypeEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Support\Enums\BupotDokumenTypeEnum;
use App\Repositories\BupotDokumenRepository;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bupots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembuat_id')->constrained()->onDelete('cascade');
            $table->foreignId('representatif_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('tipe_bupot', BupotTypeEnum::toArray())->nullable();
            $table->date('masa_awal')->nullable();
            $table->date('masa_akhir')->nullable();
            $table->boolean('pegawai_asing')->nullable();
            $table->boolean('bekerja_di_lebih_dari_satu_pemberi_kerja')->nullable();
            $table->string('npwp_akun')->nullable();
            $table->string('nama_akun')->nullable();
            $table->string('tipe_akun')->nullable();
            $table->string('alamat_utama_akun')->nullable();
            $table->string('negara_akun')->nullable();
            $table->date('tanggal_lahir_akun')->nullable();
            $table->string('tempat_lahir_akun')->nullable();
            $table->enum('jenis_kelamin_akun', GenderEnum::toArray())->nullable();
            $table->string('nip_akun')->nullable();
            $table->string('pangkat_golongan_akun')->nullable(); //BELUM FIX
            $table->string('nomor_paspor_akun')->nullable();
            $table->string('nomor_kitas_kitap_akun')->nullable();
            $table->string('email_akun')->nullable();
            $table->enum('ptkp_akun', PTKPEnum::toArray())->nullable();
            $table->string('posisi_akun')->nullable();
            $table->string('fasilitas_pajak')->nullable();
            $table->string('nama_objek_pajak')->nullable(); //BELUM FIX
            $table->string('jenis_pajak')->nullable(); //BELUM FIX
            $table->string('kode_objek_pajak')->nullable(); //BELUM FIX
            $table->string('sifat_pajak_penghasilan')->nullable();
            $table->string('jenis_pemotongan')->nullable(); //ENUM {Kurang dari Setahun, Kurang dari setahun yang penghasilannya disetahunkan, Setahun Penuh}
            $table->decimal('bruto_2_tahun')->nullable();
            $table->decimal('tunjangan_istri')->nullable();
            $table->decimal('tunjangan_anak')->nullable();
            $table->decimal('tunjangan_perbaikan_penghasilan')->nullable();
            $table->decimal('tunjungan_struktural_fungsional')->nullable();
            $table->decimal('tunjangan_beras')->nullable();
            $table->decimal('penghasilan_tetap_lainnya')->nullable();
            $table->decimal('dasar_pengenaan_pajak')->nullable();
            $table->float('persentase_penghasilan_bersih')->nullable();
            $table->float('tarif_pajak')->nullable();
            $table->decimal('pajak_penghasilan')->nullable();
            $table->decimal('gaji_pokok_pensiun')->nullable();
            $table->decimal('pembulatan_kotor')->nullable();
            $table->decimal('tunjangan_pph')->nullable();
            $table->decimal('tunjangan_lainnya')->nullable();
            $table->decimal('honorarium_imbalan_lainnya')->nullable();
            $table->decimal('premi_asuransi_pemberi_kerja')->nullable();
            $table->decimal('natura_pph_pasal_21')->nullable();
            $table->decimal('tantiem_bonus_gratifikasi_jasa_thr')->nullable();
            $table->decimal('biaya_jabatan')->nullable();
            $table->decimal('iuran_pensiun')->nullable();
            $table->decimal('sumbangan_keagamaan_pemberi_kerja')->nullable();
            $table->decimal('jumlah_pengurangan')->nullable();
            $table->decimal('jumlah_penghasilan_neto')->nullable();
            $table->decimal('nomor_bpa1_sebelumnya')->nullable();
            $table->decimal('penghasilan_neto_sebelumnya')->nullable();
            $table->decimal('penghasilan_neto_pph_pasal_21')->nullable();
            $table->decimal('penghasilan_tidak_kena_pajak')->nullable();
            $table->decimal('penghasilan_kena_pajak')->nullable();
            $table->decimal('pph_pasal_21_ditanggung_pemerintah')->nullable();
            $table->decimal('pph_pasal_21_masa_pajak_terakhir')->nullable();
            $table->decimal('pph_pasal_21_penghasilan_kena_pajak')->nullable();
            $table->decimal('pph_pasal_21_terutang')->nullable();
            $table->decimal('pph_pasal_21_potongan_bpa1_sebelumnya')->nullable();
            $table->decimal('pph_pasal_21_terutang_bupot_ini')->nullable();
            $table->string('kap')->nullable();
            $table->string('nitku')->nullable();
            $table->enum('jenis_dokumen', BupotDokumenTypeEnum::toArray())->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->date('tanggal_dokumen')->nullable();
            $table->string('nitku_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bupots');
    }
};
