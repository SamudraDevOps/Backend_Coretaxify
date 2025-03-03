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
        Schema::create('informasi_umums', function (Blueprint $table) {
            $table->id();
             
            $table->string('npwp')->nullable();
            $table->string('jenis_wajib_pajak')->nullable();
            $table->string('nama')->nullable();
            $table->string('kategori_wajib_pajak')->nullable();
            $table->string('negara_asal')->nullable();
            $table->date('tanggal_keputusan_pengesahan')->nullable();
            $table->string('nomor_keputusan_pengesahan_perubahan')->nullable();
            $table->date('tanggal_surat_keputusasan_pengesahan_perubahan')->nullable();
            $table->string('dead_of_establishment_document_number')->nullable();
            $table->string('place_of_establishment')->nullable();
            $table->date('tanggal_pendirian')->nullable();
            $table->string('notary_office_nik')->nullable();
            $table->string('notary_office_name')->nullable();
            $table->string('jenis_perusahaan')->nullable();
            $table->integer('authorized_capital')->nullable();
            $table->string('issued_capital')->nullable();
            $table->string('paid_in_capital')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('bahasa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_umums');
    }
};