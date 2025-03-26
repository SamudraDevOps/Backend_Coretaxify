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
        Schema::create('sistems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_user_id')->nullable()->constrained();
            $table->foreignId('portal_saya_id')->nullable()->constrained();
            // $table->foreignId('spt_id')->nullable()->constrained();
            // $table->foreignId('faktur_id')->nullable()->constrained();
            $table->string('nama_akun');
            $table->string('npwp_akun');
            $table->string('tipe_akun');
            $table->string('alamat_utama_akun');
            $table->string('email_akun');
            $table->timestamps();
        });

        Schema::table('detail_kontaks', function (Blueprint $table) {
            $table->foreignId('sistem_id')->constrained()->onDelete('cascade');
        });

        Schema::table('tempat_kegiatan_usahas', function (Blueprint $table) {
            $table->foreignId('sistem_id')->constrained()->onDelete('cascade');
        });

        Schema::table('detail_banks', function (Blueprint $table) {
            $table->foreignId('sistem_id')->constrained()->onDelete('cascade');
        });

        Schema::table('unit_pajak_keluargas', function (Blueprint $table) {
            $table->foreignId('sistem_id')->constrained()->onDelete('cascade');
        });

        Schema::table('pihak_terkaits', function (Blueprint $table) {
            $table->foreignId('akun_op')->references('id')->on('sistems');
            $table->foreignId('sistem_id')->references('id')->on('sistems');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sistems');
    }
};
