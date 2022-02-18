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
                'name' => "Utku",
                'firstname' => "Emilie",
                'age' => 24,
                'postalcode' => 1785,
                'role_id' => 1,
                'city' => "merchtem",
                'email' => "info@inno.be",
                'password' => Hash::make('F-urniture19'),
                "created_at" => now()
            ],
            [
                'name' => "Calis",
                'firstname' => "Ay",
                'age' => 25,
                'postalcode' => 1070,
                'role_id' => 1,
                'city' => "anderlecht",
                'email' => "ayhan.cln1997@hotmail.com",
                'password' => Hash::make('F-urniture19'),
                "created_at" => now()
            ],
        ]);
    }
}
