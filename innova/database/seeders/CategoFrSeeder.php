<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoFrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('catego_frs')->insert([

            [
                "name" => "Salon",
                "created_at" => now()
            ],
            [
                "name" => "Salle-à-manger",
                "created_at" => now()
            ],
            [
                "name" => "Chambre-à-coucher",
                "created_at" => now()
            ],
            [
                "name" => "Chambre-bébé-et-enfant",
                "created_at" => now()
            ],
            [
                "name" => "Cuisine",
                "created_at" => now()
            ],
            [
                "name" => "Buanderie",
                "created_at" => now()
            ],
            [
                "name" => "Bureau",
                "created_at" => now()
            ],
            [
                "name" => "Entrée",
                "created_at" => now()
            ],
            [
                "name" => "Décoration",
                "created_at" => now()
            ],
            [
                "name" => "Tapis",
                "created_at" => now()
            ],
            [
                "name" => "Luminaire",
                "created_at" => now()
            ],
            [
                "name" => "Textile",
                "created_at" => now()
            ],
            [
                "name" => "Audio",
                "created_at" => now()
            ],
            //CAT OUTDOOR
            [
                "name" => "Terrasse",
                "created_at" => now()
            ],
            [
                "name" => "Jardin",
                "created_at" => now()
            ],
            [
                "name" => "Décoration-out",
                "created_at" => now()
            ],
            [
                "name" => "Tapis-out",
                "created_at" => now()
            ],
            [
                "name" => "Audio-out",
                "created_at" => now()
            ],
        ]);
    }
}
