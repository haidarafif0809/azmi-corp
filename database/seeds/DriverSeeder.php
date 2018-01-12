<?php

use Illuminate\Database\Seeder;
use App\Driver;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Driver::create(['kode' => '1','nama' => 'budi']);
        Driver::create(['kode' => '2','nama' => 'yadi']);
    }
}
