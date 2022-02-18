<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Category_ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories_product')->insert([

            [
                "product_id" => 1,
                "categories_id" => 1,
                "created_at" => now()

            ],
            [
                "product_id" => 1,
                "categories_id" => 2,
                "created_at" => now()

            ],
            [
                "product_id" => 1,
                "categories_id" => 3,
                "created_at" => now()

            ],
            [
                "product_id" => 1,
                "categories_id" => 4,
                "created_at" => now()

            ],
            [
                "product_id" => 1,
                "categories_id" => 5,
                "created_at" => now()

            ],
            [
                "product_id" => 2,
                "categories_id" => 2,
                "created_at" => now()

            ],
            [
                "product_id" => 3,
                "categories_id" => 3,
                "created_at" => now()

            ],
            [
                "product_id" => 4,
                "categories_id" => 4,
                "created_at" => now()

            ],
            [
                "product_id" => 5,
                "categories_id" => 16,
                "created_at" => now()

            ],
            [
                "product_id" => 5,
                "categories_id" => 17,
                "created_at" => now()

            ],
            [
                "product_id" => 6,
                "categories_id" => 18,
                "created_at" => now()

            ],

            

        ]);
    }
}
