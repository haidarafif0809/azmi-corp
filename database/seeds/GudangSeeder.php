<?php

use Illuminate\Database\Seeder;
use App\Gudang;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Gudang::create(['kode' => 1,'nama' => 'gudang 1']);
        Gudang::create(['kode' => 2,'nama' => 'gudang 2']);

    }
}
