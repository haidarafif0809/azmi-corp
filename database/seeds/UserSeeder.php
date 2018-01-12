<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['email' => 'admin@gmail.com','name' => 'admin','password' => bcrypt('rahasia'),'konfirmasi_admin' => 1]);
        User::create(['email' => 'member@gmail.com','name' => 'member', 'password' => bcrypt('rahasia'),'konfirmasi_admin' => 1]);
        User::create(['email' => 'memberbaru@gmail.com','name' => 'member baru', 'password' => bcrypt('rahasia'),'konfirmasi_admin' => 0]);
        //
    }
}
