<?php

use Illuminate\Database\Seeder;
use App\Mobil;
class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Mobil::create(['kode' => 1 ,'plat' => '010101']);
        Mobil::create(['kode' => 2 ,'plat' => '0020202']);
    }
}
