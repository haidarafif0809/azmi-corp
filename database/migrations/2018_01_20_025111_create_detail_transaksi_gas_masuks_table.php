<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransaksiGasMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_gas_masuks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('produk_id')->unsigned();
            $table->string('nama');
            $table->string('kode_produk');
            $table->integer('kosong_p')->nullable();
            $table->integer('harga_kosong_p')->nullable();
            $table->integer('kosong_r')->nullable();
            $table->integer('harga_kosong_r')->nullable();
            $table->integer('kosong_k')->nullable();
            $table->integer('isi')->nullable();
            $table->integer('harga_isi')->nullable();
            $table->string('no_rute');
            $table->integer('transaksi_gas_id')->unsigned();
            $table->timestamps();
            $table->foreign('produk_id')->references('id')->on('produks');
            $table->foreign('transaksi_gas_id')->references('id')
                  ->on('transaksi_gas') ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi_gas_masuks');
    }
}
