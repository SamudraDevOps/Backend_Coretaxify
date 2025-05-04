<?php

use App\Support\Enums\SptModelEnum;
use App\Support\Enums\SptStatusEnum;
use App\Support\Enums\JenisPajakEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spts', function (Blueprint $table) {
            $table->id();
            $table->enum('status', SptStatusEnum::toArray())->nullable();
            $table->enum('model', SptModelEnum::toArray())->nullable();
            $table->enum('jenis_pajak', JenisPajakEnum::toArray())->nullable();
            $table->string('masa_pajak')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->date('tanggal_dibuat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spts');
    }
};
