<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiKartuKreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_kartu_kredits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_trans');
            $table->integer('kartu_kredit')->unsigned();
            $table->integer('akun')->unsigned();
            $table->integer('masuk')->default(0);
            $table->integer('keluar')->default(0);
            $table->string('deskripsi')->nullable();
            $table->timestamps();
            $table->foreign('kartu_kredit')->references('id')->on('akuns');
            $table->foreign('akun')->references('id')->on('akuns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_kartu_kredits');
    }
}
