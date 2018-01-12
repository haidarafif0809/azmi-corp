<?php

use Illuminate\Database\Seeder;
use App\Pelanggan;
class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Pelanggan::create(['kode' => '1','nama' => 'budi 1','kontak' => '11']);
        Pelanggan::create(['kode' => '2','nama' => 'budi 2','kontak' => '21']);
    }
}
