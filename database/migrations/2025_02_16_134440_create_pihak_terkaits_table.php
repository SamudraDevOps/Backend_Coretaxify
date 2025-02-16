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
        Schema::create('pihak_terkaits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('tipe_pihak_terkait');
            $table->boolean('is_pic');
            $table->string('jenis_orang_terkait');
            $table->string('npwp');
            $table->string('nomor_paspor');
            $table->string('kewarganegaraan');
            $table->string('negara_asal');
            $table->string('email');
            $table->string('nomor_handphone');
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pihak_terkaits');
    }
};