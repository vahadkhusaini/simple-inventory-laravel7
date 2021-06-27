<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKartuStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kartu_stok', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('barang_id', 11);
            $table->integer('masuk');
            $table->integer('harga_beli');
            $table->integer('keluar');
            $table->integer('harga_jual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kartu_stok');
    }
}
