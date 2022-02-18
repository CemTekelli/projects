<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([

            [
                "user" => "Ayhan",
                "email" => "test@test.com",
                'number' => "458684",
                "commentaire" => "trop bien",
                'product_id' => 1,
                'validate' => true,
                "date" => now(),
                "created_at" => now()

            ],

            [
                "user" => "AyhaanTEST",
                "commentaire" => "vite fais",
                "email" => "test@test.com",
                'product_id' => 1,
                'validate' => false,
                'number' => "458684",
                "date" => now(),
                "created_at" => now()

            ],

            [
                "user" => "Elias",
                "commentaire" => "trop bien",
                "email" => "test@test.com",
                'product_id' => 2,
                'validate' => true,
                'number' => "458684",
                "date" => now(),
                "created_at" => now()

            ],

            [
                "user" => "Cactus",
                "commentaire" => "trop bien",
                "email" => "test@test.com",
                'product_id' => 3,
                'validate' => false,
                "date" => now(),
                'number' => "458684",
                "created_at" => now()
            ],
            [
                "user" => "Elias",
                "commentaire" => "trop bien",
                "email" => "test@test.com",
                'product_id' => 4,
                'validate' => true,
                "date" => now(),
                'number' => "458684",
                "created_at" => now()
            ],
            [
                "user" => "Nico",
                "commentaire" => "trop bien",
                "email" => "test@test.com",
                'product_id' => 5,
                'validate' => true,
                "date" => now(),
                'number' => "458684",
                "created_at" => now()
            ],

        ]);
    }
}
