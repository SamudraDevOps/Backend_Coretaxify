<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portal_sayas', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('dokumen_saya_id')->nullable()->constrained();
            // $table->foreignId('notifikasi_saya_id')->nullable()->constrained();
            // $table->foreignId('kasus_id')->nullable()->constrained();
            // $table->foreignId('kasus_berjalan_saya_id')->nullable()->constrained();
            $table->foreignId('profil_saya_id')->nullable()->constrained();
            // $table->foreignId('permintaan_kode_otorisasi_id')->nullable()->constrained();
            // $table->foreignId('pengukuhan_pkp_id')->nullable()->constrained();
            // $table->foreignId('pendaftaran_objek_pajak_pbb_psl_id')->nullable()->constrained();
            // $table->foreignId('perubahan_data')->nullable()->constrained();
            // $table->foreignId('perubahan_status')->nullable()->constrained();
            // $table->foreignId('penghapusan_pencabutan_id')->nullable()->constrained();
            // $table->foreignId('profil_institusi_finansial_od')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_sayas');
    }
};