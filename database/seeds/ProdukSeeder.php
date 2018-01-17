<?php

use Illuminate\Database\Seeder;
use App\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Produk::create(['kode' => '3kg' ,'nama' => 'Gas 3 Kg']);
        Produk::create(['kode' => '15kg' ,'nama' => 'Gas 15 Kg']);
        Produk::create(['kode' => '20kg' ,'nama' => 'Gas 20 Kg']);

    }
}
