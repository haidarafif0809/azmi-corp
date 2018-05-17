<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiGasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_gas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_rute')->unique();
            $table->string('mobil')->nullable();
            $table->string('status_barang');
            $table->string('asal_barang');
            $table->string('tujuan_barang');
            $table->string('driver')->nullable();
            $table->decimal('uang_jalan',15,2)->nullable();
            $table->integer('akun_masuk')->unsigned();
            $table->integer('akun_keluar')->unsigned();
            $table->string('no_kas');
            $table->timestamps();
            $table->foreign('akun_masuk')->references('id')->on('akuns');
            $table->foreign('akun_keluar')->references('id')->on('akuns');
            $table->foreign('no_kas')->references('no_trans')->on('transaksi_kas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_gas');
    }
}
