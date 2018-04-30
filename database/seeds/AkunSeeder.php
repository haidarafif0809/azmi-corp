<?php

use Illuminate\Database\Seeder;
use App\Akun;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Akun::create(['kode' => '1' , 'nama' => 'KAS UTAMA','jenis' => 'kas']);
        Akun::create(['kode' => '2' , 'nama' => 'KAS GUDANG 1','jenis' => 'kas']);
        Akun::create(['kode' => '3' , 'nama' => 'KAS GUDANG 2','jenis' => 'kas']);
        Akun::create(['kode' => '4' , 'nama' => 'KAS BUTIK','jenis' => 'kas']);
        Akun::create(['kode' => '5' , 'nama' => 'KAS BMT','jenis' => 'kas']);
        Akun::create(['kode' => '6' , 'nama' => 'PENJUALAN','jenis' => 'penjualan']);
        Akun::create(['kode' => '7' , 'nama' => 'PEMBELIAN','jenis' => 'pembelian']);
        Akun::create(['kode' => '8' , 'nama' => 'PIUTANG','jenis' => 'piutang']);
        Akun::create(['kode' => '10' , 'nama' => 'modal','jenis' => 'modal']);
        Akun::create(['kode' => '11' , 'nama' => 'biaya','jenis' => 'biaya']);
        Akun::create(['kode' => '12' , 'nama' => 'persediaan','jenis' => 'persediaan']);
        Akun::create(['kode' => '13' , 'nama' => 'Kartu Kredit','jenis' => 'hutang']);
    }
}
