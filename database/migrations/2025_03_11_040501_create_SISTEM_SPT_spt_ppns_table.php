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
        Schema::create('spt_ppns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pic_id')->references('id')->on('pics')->nullable();
            $table->string('periode')->nullable();
            $table->string('klasifikasi_lapangan_usaha')->nullable();
            $table->boolean('is_pembetulan')->nullable();

            $table->decimal('cl_1a1_dpp',18,2)->nullable();
            $table->decimal('cl_1a2_dpp',18,2)->nullable();
            $table->decimal('cl_1a3_dpp',18,2)->nullable();
            $table->decimal('cl_1a4_dpp',18,2)->nullable();
            $table->decimal('cl_1a5_dpp',18,2)->nullable();
            $table->decimal('cl_1a6_dpp',18,2)->nullable();
            $table->decimal('cl_1a7_dpp',18,2)->nullable();
            $table->decimal('cl_1a8_dpp',18,2)->nullable();
            $table->decimal('cl_1a9_dpp',18,2)->nullable();
            $table->decimal('cl_1a_jumlah_dpp',18,2)->nullable();
            $table->decimal('cl_1b_dpp',18,2)->nullable();
            $table->decimal('cl_1c_dpp',18,2)->nullable();
            $table->decimal('cl_1a2_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a3_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a5_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a6_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a7_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a8_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a9_dpp_lain',18,2)->nullable();
            $table->decimal('cl_1a2_ppn',18,2)->nullable();
            $table->decimal('cl_1a4_ppn',18,2)->nullable();
            $table->decimal('cl_1a3_ppn',18,2)->nullable();
            $table->decimal('cl_1a5_ppn',18,2)->nullable();
            $table->decimal('cl_1a6_ppn',18,2)->nullable();
            $table->decimal('cl_1a7_ppn',18,2)->nullable();
            $table->decimal('cl_1a8_ppn',18,2)->nullable();
            $table->decimal('cl_1a9_ppn',18,2)->nullable();
            $table->decimal('cl_1a_jumlah_ppn',18,2)->nullable();
            $table->decimal('cl_1a2_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a4_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a3_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a5_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a6_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a7_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a8_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a9_ppnbm',18,2)->nullable();
            $table->decimal('cl_1a_jumlah_ppnbm',18,2)->nullable();

            $table->decimal('cl_2a_dpp',18,2)->nullable();
            $table->decimal('cl_2b_dpp_lain',18,2)->nullable();
            $table->decimal('cl_2b_dpp',18,2)->nullable();
            $table->decimal('cl_2c_dpp',18,2)->nullable();
            $table->decimal('cl_2d_dpp_lain',18,2)->nullable();
            $table->decimal('cl_2a_ppnbm',18,2)->nullable();
            $table->decimal('cl_2b_ppnbm',18,2)->nullable();
            $table->decimal('cl_2c_ppnbm',18,2)->nullable();
            $table->decimal('cl_2d_ppnbm',18,2)->nullable();
            $table->decimal('cl_2d_dpp',18,2)->nullable();
            $table->decimal('cl_2g_dpp',18,2)->nullable();
            $table->decimal('cl_2h_dpp_lain',18,2)->nullable();
            $table->decimal('cl_2a_ppn',18,2)->nullable();
            $table->decimal('cl_2b_ppn',18,2)->nullable();
            $table->decimal('cl_2c_ppn',18,2)->nullable();
            $table->decimal('cl_2d_ppn',18,2)->nullable();
            $table->decimal('cl_2e_ppn',18,2)->nullable();
            $table->decimal('cl_2f_ppn',18,2)->nullable();
            $table->decimal('cl_2g_ppn',18,2)->nullable();
            $table->decimal('cl_2h_ppn',18,2)->nullable();
            $table->decimal('cl_2h_dpp',18,2)->nullable();
            $table->decimal('cl_2h_ppnbm',18,2)->nullable();
            $table->decimal('cl_2i_dpp',18,2)->nullable();
            $table->decimal('cl_2j_dpp',18,2)->nullable();

            $table->decimal('cl_3a_ppn',18,2)->nullable();
            $table->decimal('cl_3b_ppn',18,2)->nullable();
            $table->decimal('cl_3c_ppn',18,2)->nullable();
            $table->decimal('cl_3d_ppn',18,2)->nullable();
            $table->decimal('cl_3e_ppn',18,2)->nullable();
            $table->decimal('cl_3f_ppn',18,2)->nullable();
            $table->decimal('cl_3g_ppn',18,2)->nullable();
            $table->string('cl_3h_diminta')->nullable();
            $table->string('cl_3h_nomor_rekening')->nullable();
            $table->string('cl_3h_nama_bank')->nullable();
            $table->string('cl_3h_nama_pemilik_rekening')->nullable();

            $table->decimal('cl_4_ppn_terutang_dpp', 18, 2)->nullable();
            $table->decimal('cl_4_ppn_terutang', 18, 2)->nullable();

            $table->decimal('cl_5_ppn_wajib', 18, 2)->nullable();

            $table->decimal('cl_6a_ppnbm',18,2)->nullable();
            $table->decimal('cl_6b_ppnbm',18,2)->nullable();
            $table->decimal('cl_6c_ppnbm',18,2)->nullable();
            $table->decimal('cl_6d_ppnbm',18,2)->nullable();
            $table->decimal('cl_6e_ppnbm',18,2)->nullable();
            $table->boolean('cl_6f_diminta_pengembalian')->nullable();

            $table->decimal('cl_7a_ppnbm',18,2)->nullable();
            $table->decimal('cl_7b_ppnbm',18,2)->nullable();
            $table->decimal('cl_7c_ppnbm',18,2)->nullable();
            $table->decimal('cl_7a_ppn',18,2)->nullable();
            $table->decimal('cl_7b_ppn',18,2)->nullable();
            $table->decimal('cl_7c_ppn',18,2)->nullable();
            $table->decimal('cl_7a_dpp_lain',18,2)->nullable();
            $table->decimal('cl_7b_dpp_lain',18,2)->nullable();
            $table->decimal('cl_7c_dpp_lain',18,2)->nullable();
            $table->decimal('cl_7a_dpp',18,2)->nullable();
            $table->decimal('cl_7b_dpp',18,2)->nullable();
            $table->decimal('cl_7c_dpp',18,2)->nullable();

            $table->decimal('cl_8a_ppnbm',18,2)->nullable();
            $table->decimal('cl_8b_ppnbm',18,2)->nullable();
            $table->decimal('cl_8c_ppnbm',18,2)->nullable();
            $table->decimal('cl_8a_ppn',18,2)->nullable();
            $table->decimal('cl_8b_ppn',18,2)->nullable();
            $table->decimal('cl_8c_ppn',18,2)->nullable();
            $table->decimal('cl_8a_dpp_lain',18,2)->nullable();
            $table->decimal('cl_8b_dpp_lain',18,2)->nullable();
            $table->decimal('cl_8c_dpp_lain',18,2)->nullable();
            $table->decimal('cl_8a_dpp',18,2)->nullable();
            $table->decimal('cl_8b_dpp',18,2)->nullable();
            $table->decimal('cl_8c_dpp',18,2)->nullable();
            $table->boolean('cl_8d_diminta_pengembalian')->nullable();

            $table->boolean('cl_9a_daftar')->nullable();
            $table->boolean('cl_9b_hasil_perhitungan')->nullable();

            $table->date('cl_10_batas_waktu')->nullable();

            $table->timestamps();
        });

        // Schema::table('fakturs', function (Blueprint $table) {
        //     $table->unsignedBigInteger('spt_ppns_id')->nullable()->change();
        //     $table->foreignId('spt_ppns_id')->onDelete('cascade')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spt_ppns');
    }
};