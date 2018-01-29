<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJurnalManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_manuals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_trans')->unique();
            $table->integer('akun_debit')->unsigned();
            $table->integer('akun_kredit')->unsigned();
            $table->string('deskripsi')->nullable();
            $table->decimal('jumlah',15,2);
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
        Schema::dropIfExists('jurnal_manuals');
    }
}
