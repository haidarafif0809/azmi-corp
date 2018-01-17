<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiKasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_trans')->unique();
            $table->integer('akun_masuk')->unsigned();
            $table->integer('akun_keluar')->unsigned();
            $table->string('deskripsi')->nullable();
            $table->float('masuk')->default(0);
            $table->float('keluar')->default(0);
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
        Schema::dropIfExists('transaksi_kas');
    }
}
