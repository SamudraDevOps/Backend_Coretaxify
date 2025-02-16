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
        Schema::create('data_ekonomis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('assignment_users_id')->constrained()->onDelete('cascade');
            $table->string('merek_dagang');
            $table->boolean('is_karyuawan');
            $table->string('jumlah_karyawan');
            $table->string('metode_pembukuan');
            $table->string('mata_uang_pembukuan');
            $table->string('periode_pembukuan');
            $table->string('omset_per_tahun');
            $table->string('jumlah_peredaran_bruto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ekonomis');
    }
};