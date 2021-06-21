<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('no_nota', 100);
            $table->date('tanggal');
            $table->string('supplier_id', 11);
            $table->date('tanggal_jatuh_tempo');
            $table->enum('jenis_pembayaran',['T', 'K']);
            $table->enum('status',[0, 1, 2]);
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
        Schema::dropIfExists('pembelian');
    }
}
