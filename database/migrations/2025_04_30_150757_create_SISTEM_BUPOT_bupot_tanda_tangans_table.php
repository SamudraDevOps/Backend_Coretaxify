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
        Schema::create('bupot_tanda_tangans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_penandatanganan');
            $table->string('penyedia_penandatangan');
            $table->string('id_penandatangan');
            $table->string('katasandi_penandatangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bupot_tanda_tangans');
    }
};
