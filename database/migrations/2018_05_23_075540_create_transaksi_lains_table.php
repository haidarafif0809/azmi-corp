<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiLainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_lains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_trans')->unique();
            $table->string('no_rute')->unique();
            $table->integer('akun_debit')->unsigned();
            $table->integer('akun_kredit')->unsigned();
            $table->decimal('jumlah',15,2)->nullable();
            $table->timestamps();
            $table->foreign('akun_debit')->references('id')->on('akuns');
            $table->foreign('akun_kredit')->references('id')->on('akuns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_lains');
    }
}
