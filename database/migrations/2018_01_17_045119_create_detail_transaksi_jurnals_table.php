<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailTransaksiJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi_jurnals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_jurnal');
            $table->integer('trans_id');
            $table->string('no_trans');
            $table->integer('akun_id');
            $table->string('jenis_trans');
            $table->string('deskripsi');
            $table->float('debit')->default(0);
            $table->float('kredit')->default(0);
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
        Schema::dropIfExists('detail_transaksi_jurnals');
    }
}
