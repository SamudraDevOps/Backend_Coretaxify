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
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->integer('npwp');
            $table->string('jenis_wajib_pajak');
            $table->string('nama');
            $table->string('kategori_wajib_pajak');
            $table->string('negara_asal');
            $table->date('tanggal_keputusan_pengesahan');
            $table->string('nomor_keputusan_pengesahan_perubahan');
            $table->date('tanggal_surat_keputusasan_pengesahan_perubahan');
            $table->string('dead_of_establishment_document_number');
            $table->string('place_of_establishment');
            $table->date('tanggal_pendirian');
            $table->string('notary_office_nik');
            $table->string('notary_office_name');
            $table->string('jenis_perusahaan');
            $table->integer('authorized_capital');
            $table->string('issued_capital');
            $table->string('paid_in_capital');
            $table->string('kewarganegaraan');
            $table->string('bahasa');
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