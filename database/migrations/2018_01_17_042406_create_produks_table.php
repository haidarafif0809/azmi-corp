<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode')->unique();
            $table->string('nama')->unique();
            $table->integer('kosong_p')->nullable();
            $table->integer('harga_kosong_p')->default(0);
            $table->integer('kosong_r')->nullable();
            $table->integer('harga_kosong_r')->default(0);
            $table->integer('kosong_k')->nullable();
            $table->integer('isi')->nullable();
            $table->integer('harga_isi')->default(0);
            $table->string('warna')->unique();
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
        Schema::dropIfExists('produks');
    }
}
