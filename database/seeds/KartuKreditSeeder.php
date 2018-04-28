<?php

use Illuminate\Database\Seeder;
use App\KartuKredit;

class KartuKreditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        KartuKredit::create(['kode' => 1,'nama' => 'kartu 1', 'limit' => 100000,]);
        KartuKredit::create(['kode' => 2,'nama' => 'kartu 2', 'limit' => 100000,]);
    }
}
