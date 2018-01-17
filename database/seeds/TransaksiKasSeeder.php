<?php

use Illuminate\Database\Seeder;
use App\TransaksiKas;
class TransaksiKasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TransaksiKas::create(['akun_masuk' => 1, 'akun_keluar' => 10, 'deskripsi' => 'modal pak budi','masuk' => 10000]);
        TransaksiKas::create(['akun_masuk' => 11, 'akun_keluar' => 1, 'deskripsi' => 'biaya jajan','keluar' => 10000]);
    }
}
