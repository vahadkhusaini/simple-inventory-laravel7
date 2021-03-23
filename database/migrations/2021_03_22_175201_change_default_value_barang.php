<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultValueBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->integer('harga_jual')->nullable()->change();
            $table->integer('harga_beli')->nullable()->change();
            $table->integer('stok')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('barang', function (Blueprint $table) {
            $table->integer('harga_jual')->change();
            $table->integer('harga_beli')->change();
            $table->integer('stok')->change();
        });
    }
}
