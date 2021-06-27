<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableKartuStok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kartu_stok', function (Blueprint $table) {
            $table->integer('harga');
            $table->dropColumn(['harga_beli', 'harga_jual', 'created_at', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kartu_stok', function (Blueprint $table) {
            $table->integer('harga_beli');
            $table->integer('harga_jual');
        });
    }
}
