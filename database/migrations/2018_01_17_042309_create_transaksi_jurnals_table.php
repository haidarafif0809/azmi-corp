<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiJurnalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_jurnals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_jurnal')->unique();
            $table->string('no_trans');
            $table->integer('jumlah_akun');
            $table->string('jenis_trans');
            $table->string('deskripsi')->nullable();
            $table->float('total_nilai');
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
        Schema::dropIfExists('transaksi_jurnals');
    }
}
