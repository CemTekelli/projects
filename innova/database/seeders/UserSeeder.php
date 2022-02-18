<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => "Uslu",
                'firstname' => "Emilie Ecem",
                'age' => 24,
                'postalcode' => 1785,
                'role_id' => 1,
                'city' => "merchtem",
                'email' => "info@innovafurniture.be",
                'password' => Hash::make('F-urniture19'),
                "created_at" => now()
            ],
            [
                'name' => "Caliskan",
                'firstname' => "Ayhan",
                'age' => 25,
                'postalcode' => 1070,
                'role_id' => 1,
                'city' => "anderlecht",
                'email' => "ayhan.cln1997@gmail.com",
                'password' => Hash::make('F-urniture19'),
                "created_at" => now()
            ],
        ]);
    }
}
