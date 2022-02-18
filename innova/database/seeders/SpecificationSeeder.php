<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        $jsonData = array(
            'Dimensions' => '3 places dont deux relax électriques : 203 x H98 x 89 cm, 2 places sans relax électriques : 158 x H98 x 89 cm ',
            'Couleur sur la photo ' => 'Anthracite',
        );
        $jsonData = json_encode($jsonData);

        DB::table('specifications')->insert([
    
            [
                "data" => $jsonData,
                "product_id" => 1,
                "created_at" => now()
            ],
            [
                "data" => $jsonData,
                "product_id" => 2,
                "created_at" => now()
            ],
            [
                "data" => $jsonData,
                "product_id" => 3,
                "created_at" => now()
            ],
            [
                "data" => $jsonData,
                "product_id" => 4,
                "created_at" => now()
            ],
            [
                "data" => $jsonData,
                "product_id" => 5,
                "created_at" => now()
            ],
            [
                "data" => $jsonData,
                "product_id" => 6,
                "created_at" => now()
            ],
        ]);
    }
}
