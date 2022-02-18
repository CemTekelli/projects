<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([

            [
                "img" => "salon-one.png",
                "product_id" => 1,
                "created_at" => now()
            ],
            [
                "img" => "salon-1.jfif",
                "product_id" => 1,
                "created_at" => now()
            ],
            [
                "img" => "chambre-1.jfif",
                "product_id" => 1,
                "created_at" => now()
            ],
            [
                "img" => "tapis.jfif",
                "product_id" => 1,
                "created_at" => now()
            ],
            [
                "img" => "chambre-1.jfif",
                "product_id" => 2,
                "created_at" => now()
            ],
            [
                "img" => "salon-1.jfif",
                "product_id" => 2,
                "created_at" => now()
            ],
            [
                "img" => "tapis.jfif",
                "product_id" => 2,
                "created_at" => now()
            ],
            [
                "img" => "table.jfif",
                "product_id" => 3,
                "created_at" => now()
            ],
            [
                "img" => "tapis.jfif",
                "product_id" => 3,
                "created_at" => now()
            ],
            [
                "img" => "chambre-1.jfif",
                "product_id" => 3,
                "created_at" => now()
            ],
            [
                "img" => "salon-1.jfif",
                "product_id" => 3,
                "created_at" => now()
            ],
            [
                "img" => "table.jfif",
                "product_id" => 4,
                "created_at" => now()
            ],
            [
                "img" => "chambre-1.jfif",
                "product_id" => 4,
                "created_at" => now()
            ],
            [
                "img" => "salon-1.jfif",
                "product_id" => 4,
                "created_at" => now()
            ],
            [
                "img" => "tapis.jfif",
                "product_id" => 5,
                "created_at" => now()
            ],
            [
                "img" => "chambre-1.jfif",
                "product_id" => 5,
                "created_at" => now()
            ],
            [
                "img" => "salon-1.jfif",
                "product_id" => 6,
                "created_at" => now()
            ],


        ]);
    }
}
