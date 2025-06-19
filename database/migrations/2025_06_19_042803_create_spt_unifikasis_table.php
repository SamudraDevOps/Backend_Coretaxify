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
        Schema::create('spt_unifikasis', function (Blueprint $table) {
            $table->id();
            $table->decimal('cl_total_setor',18,2)->nullable();
            $table->decimal('cl_total_potong',18,2)->nullable();
            $table->decimal('cl_total_tanggung',18,2)->nullable();
            $table->decimal('cl_total_bayar',18,2)->nullable();
            $table->decimal('cl_total_betul',18,2)->nullable();
            $table->decimal('cl_a_pasal26',18,2)->nullable();
            $table->decimal('cl_a_pasal23',18,2)->nullable();
            $table->decimal('cl_a_pasal22',18,2)->nullable();
            $table->decimal('cl_a_pasal15',18,2)->nullable();
            $table->decimal('cl_a_pasal4',18,2)->nullable();
            $table->decimal('cl_a_1',18,2)->nullable();
            $table->decimal('cl_a_2',18,2)->nullable();
            $table->decimal('cl_a_3',18,2)->nullable();
            $table->decimal('cl_a_4',18,2)->nullable();
            $table->decimal('cl_a_5',18,2)->nullable();
            $table->decimal('cl_a_6',18,2)->nullable();
            $table->decimal('cl_a_7',18,2)->nullable();
            $table->decimal('cl_a_8',18,2)->nullable();
            $table->decimal('cl_a_9',18,2)->nullable();
            $table->decimal('cl_a_10',18,2)->nullable();
            $table->decimal('cl_b_pasal26',18,2)->nullable();
            $table->decimal('cl_b_pasal23',18,2)->nullable();
            $table->decimal('cl_b_pasal22',18,2)->nullable();
            $table->decimal('cl_b_pasal15',18,2)->nullable();
            $table->decimal('cl_b_pasal4',18,2)->nullable();
            $table->decimal('cl_b_1',18,2)->nullable();
            $table->decimal('cl_b_2',18,2)->nullable();
            $table->decimal('cl_b_3',18,2)->nullable();
            $table->decimal('cl_b_4',18,2)->nullable();
            $table->decimal('cl_b_5',18,2)->nullable();
            $table->decimal('cl_b_6',18,2)->nullable();
            $table->decimal('cl_b_7',18,2)->nullable();
            $table->decimal('cl_b_8',18,2)->nullable();
            $table->decimal('cl_b_9',18,2)->nullable();
            $table->decimal('cl_b_10',18,2)->nullable();
            $table->decimal('cl_c_pasal26',18,2)->nullable();
            $table->decimal('cl_c_pasal23',18,2)->nullable();
            $table->decimal('cl_c_pasal22',18,2)->nullable();
            $table->decimal('cl_c_pasal15',18,2)->nullable();
            $table->decimal('cl_c_pasal4',18,2)->nullable();
            $table->decimal('cl_c_1',18,2)->nullable();
            $table->decimal('cl_c_2',18,2)->nullable();
            $table->decimal('cl_c_3',18,2)->nullable();
            $table->decimal('cl_c_4',18,2)->nullable();
            $table->decimal('cl_c_5',18,2)->nullable();
            $table->decimal('cl_c_6',18,2)->nullable();
            $table->decimal('cl_c_7',18,2)->nullable();
            $table->decimal('cl_c_8',18,2)->nullable();
            $table->decimal('cl_c_9',18,2)->nullable();
            $table->decimal('cl_c_10',18,2)->nullable();
            $table->decimal('cl_d_pasal26',18,2)->nullable();
            $table->decimal('cl_d_pasal23',18,2)->nullable();
            $table->decimal('cl_d_pasal22',18,2)->nullable();
            $table->decimal('cl_d_pasal15',18,2)->nullable();
            $table->decimal('cl_d_pasal4',18,2)->nullable();
            $table->decimal('cl_d_1',18,2)->nullable();
            $table->decimal('cl_d_2',18,2)->nullable();
            $table->decimal('cl_d_3',18,2)->nullable();
            $table->decimal('cl_d_4',18,2)->nullable();
            $table->decimal('cl_d_5',18,2)->nullable();
            $table->decimal('cl_d_6',18,2)->nullable();
            $table->decimal('cl_d_7',18,2)->nullable();
            $table->decimal('cl_d_8',18,2)->nullable();
            $table->decimal('cl_d_9',18,2)->nullable();
            $table->decimal('cl_d_10',18,2)->nullable();
            $table->decimal('cl_e_pasal26',18,2)->nullable();
            $table->decimal('cl_e_pasal23',18,2)->nullable();
            $table->decimal('cl_e_pasal22',18,2)->nullable();
            $table->decimal('cl_e_pasal15',18,2)->nullable();
            $table->decimal('cl_e_pasal4',18,2)->nullable();
            $table->decimal('cl_e_1',18,2)->nullable();
            $table->decimal('cl_e_2',18,2)->nullable();
            $table->decimal('cl_e_3',18,2)->nullable();
            $table->decimal('cl_e_4',18,2)->nullable();
            $table->decimal('cl_e_5',18,2)->nullable();
            $table->decimal('cl_e_6',18,2)->nullable();
            $table->decimal('cl_e_7',18,2)->nullable();
            $table->decimal('cl_e_8',18,2)->nullable();
            $table->decimal('cl_e_9',18,2)->nullable();
            $table->decimal('cl_e_10',18,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spt_unifikasis');
    }
};