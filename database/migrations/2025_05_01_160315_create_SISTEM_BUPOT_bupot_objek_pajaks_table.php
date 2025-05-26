<?php

use App\Support\Enums\BupotTypeEnum;
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
        Schema::create('bupot_objek_pajaks', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe_bupot', BupotTypeEnum::toArray());
            $table->text('nama_objek_pajak')->nullable();
            $table->string('jenis_pajak')->nullable();
            $table->string('kode_objek_pajak')->nullable();
            $table->float('tarif_pajak')->nullable();
            $table->float('persentase_penghasilan_bersih')->nullable();
            $table->string('sifat_pajak_penghasilan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bupot_objek_pajaks');
    }
};
