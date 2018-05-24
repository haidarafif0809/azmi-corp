<?php

use Illuminate\Database\Seeder;
use App\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Perusahaan::create([
          'nama' => 'azmi gas',
          'alamat' => 'jakarta',
          'no_telp' => '081212',
          'website' => 'azmicorp.com'
        ]);
    }
}
