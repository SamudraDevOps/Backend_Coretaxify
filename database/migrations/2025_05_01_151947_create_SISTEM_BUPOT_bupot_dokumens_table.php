<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Support\Enums\BupotDokumenTypeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bupot_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bupot_id')->constrained('bupots')->onDelete('cascade');
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
        Schema::dropIfExists('bupot_dokumens');
    }
};
