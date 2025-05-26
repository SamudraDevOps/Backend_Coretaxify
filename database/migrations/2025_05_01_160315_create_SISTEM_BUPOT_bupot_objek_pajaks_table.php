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
            $table->text('nama_objek_pajak');
            $table->string('jenis_pajak');
            $table->string('kode_objek_pajak');
            $table->float('tarif_pajak');
            $table->string('sifat_pajak_penghasilan');
            $table->decimal('dasar_pengenaan_pajak')->nullable();
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
