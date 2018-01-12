<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(MobilSeeder::class);
         $this->call(SupplierSeeder::class);
         $this->call(DriverSeeder::class);
         $this->call(GudangSeeder::class);
    }
}
