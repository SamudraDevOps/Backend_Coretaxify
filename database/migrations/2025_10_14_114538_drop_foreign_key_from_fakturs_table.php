<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('fakturs', function (Blueprint $table) {
            $table->dropForeign(['akun_penerima_id']);
        });
    }

    public function down()
    {
        Schema::table('fakturs', function (Blueprint $table) {
            $table->foreign('akun_penerima_id')->references('id')->on('sistems');
        });
    }
};
