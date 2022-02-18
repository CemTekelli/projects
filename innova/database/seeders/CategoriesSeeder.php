<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('categories')->insert([

            [
                "name" => "Salon",
                "created_at" => now()
            ],
            [
                "name" => "Eetkamer",
                "created_at" => now()
            ],
            [
                "name" => "Slaapkamer",
                "created_at" => now()
            ],
            [
                "name" => "Baby-kinderkamers",
                "created_at" => now()
            ],
            [
                "name" => "Keuken",
                "created_at" => now()
            ],
            [
                "name" => "Wasserij",
                "created_at" => now()
            ],
            [
                "name" => "Kantoor",
                "created_at" => now()
            ],
            [
                "name" => "Inkomhal",
                "created_at" => now()
            ],
            [
                "name" => "Decoratie",
                "created_at" => now()
            ],
            [
                "name" => "Tapijt",
                "created_at" => now()
            ],
            [
                "name" => "Verlichting",
                "created_at" => now()
            ],
            [
                "name" => "Textiel",
                "created_at" => now()
            ],
            [
                "name" => "Audio",
                "created_at" => now()
            ],
            //CAT OUTDOOR
            [
                "name" => "Terras",
                "created_at" => now()
            ],
            [
                "name" => "Tuin",
                "created_at" => now()
            ],
            [
                "name" => "Decoratie-out",
                "created_at" => now()
            ],
            [
                "name" => "Tapijt-out",
                "created_at" => now()
            ],
            [
                "name" => "Audio-out",
                "created_at" => now()
            ],
        ]);
    }
}
