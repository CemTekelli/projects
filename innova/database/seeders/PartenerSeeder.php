<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartenerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parteners')->insert([
            [
                'img' => "bambi.png",
                "created_at" => now()
            ],
            [
                'img' => "buyway.png",
                "created_at" => now()
            ],
            [
                'img' => "fbm.png",
                "created_at" => now()
            ],
            [
                'img' => "homiris.png",
                "created_at" => now()
            ],
            [
                'img' => "idea.png",
                "created_at" => now()
            ],
            [
                'img' => "pierrecardin.png",
                "created_at" => now()
            ],
            [
                'img' => "protexx.png",
                "created_at" => now()
            ],
            [
                'img' => "sitwell.png",
                "created_at" => now()
            ],
            [
                'img' => "wiemann.png",
                "created_at" => now()
            ],
        ]);
    }
}
