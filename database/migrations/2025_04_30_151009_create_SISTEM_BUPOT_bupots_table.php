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
            $table->foreignId('pembuat_id')->references('id')->on('sistems')->onDelete('cascade');
            // $table->foreignId('representatif_id')->nullable()->references('id')->on('sistems')->onDelete('cascade');
            $table->foreignId('tanda_tangan_bupot_id')->nullable()->references('id')->on('bupot_tanda_tangans'); //BELUM FIX
            $table->enum('tipe_bupot', BupotTypeEnum::toArray())->nullable();
            $table->enum('status', ['valid', 'invalid', 'normal', 'pembetulan', 'dihapus', 'pembatalan'])->nullable();
            $table->enum('status_penerbitan', ['draft', 'published', 'invalid'])->nullable();
            $table->string('nomor_pemotongan')->nullable();
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
            $table->string('recipient_number')->nullable();
            $table->text('nama_objek_pajak')->nullable(); //BELUM FIX
            $table->string('jenis_pajak')->nullable(); //BELUM FIX
            $table->string('kode_objek_pajak')->nullable(); //BELUM FIX
            $table->string('sifat_pajak_penghasilan')->nullable();
            $table->string('jenis_pemotongan')->nullable(); //ENUM {Kurang dari Setahun, Kurang dari setahun yang penghasilannya disetahunkan, Setahun Penuh}
            $table->decimal('bruto_2_tahun', 17, 4)->nullable();
            $table->decimal('tunjangan_istri', 17, 4)->nullable();
            $table->decimal('tunjangan_anak', 17, 4)->nullable();
            $table->decimal('tunjangan_perbaikan_penghasilan', 17, 4)->nullable();
            $table->decimal('tunjungan_struktural_fungsional', 17, 4)->nullable();
            $table->decimal('tunjangan_beras', 17, 4)->nullable();
            $table->decimal('penghasilan_tetap_lainnya', 17, 4)->nullable();
            $table->decimal('dasar_pengenaan_pajak', 17, 4)->nullable();
            $table->float('persentase_penghasilan_bersih')->nullable();
            $table->float('tarif_pajak')->nullable();
            $table->decimal('pajak_penghasilan', 17, 4)->nullable();
            $table->decimal('gaji_pokok_pensiun', 17, 4)->nullable();
            $table->decimal('pembulatan_kotor', 17, 4)->nullable();
            $table->decimal('tunjangan_pph', 17, 4)->nullable();
            $table->decimal('tunjangan_lainnya', 17, 4)->nullable();
            $table->decimal('honorarium_imbalan_lainnya', 17, 4)->nullable();
            $table->decimal('premi_asuransi_pemberi_kerja', 17, 4)->nullable();
            $table->decimal('natura_pph_pasal_21', 17, 4)->nullable();
            $table->decimal('tantiem_bonus_gratifikasi_jasa_thr', 17, 4)->nullable();
            $table->decimal('biaya_jabatan', 17, 4)->nullable();
            $table->decimal('iuran_pensiun', 17, 4)->nullable();
            $table->decimal('sumbangan_keagamaan_pemberi_kerja', 17, 4)->nullable();
            $table->decimal('jumlah_pengurangan', 17, 4)->nullable();
            $table->decimal('jumlah_penghasilan_neto', 17, 4)->nullable();
            $table->decimal('nomor_bpa1_sebelumnya', 17, 4)->nullable();
            $table->decimal('penghasilan_neto_sebelumnya', 17, 4)->nullable();
            $table->decimal('penghasilan_neto_pph_pasal_21', 17, 4)->nullable();
            $table->decimal('penghasilan_tidak_kena_pajak', 17, 4)->nullable();
            $table->decimal('penghasilan_kena_pajak', 17, 4)->nullable();
            $table->decimal('pph_pasal_21_ditanggung_pemerintah', 17, 4)->nullable();
            $table->decimal('pph_pasal_21_masa_pajak_terakhir', 17, 4)->nullable();
            $table->decimal('pph_pasal_21_penghasilan_kena_pajak', 17, 4)->nullable();
            $table->decimal('pph_pasal_21_terutang', 17, 4)->nullable();
            $table->decimal('pph_pasal_21_potongan_bpa1_sebelumnya', 17, 4)->nullable();
            $table->decimal('pph_pasal_21_terutang_bupot_ini', 17, 4)->nullable();
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
