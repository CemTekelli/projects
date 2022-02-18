<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                "name" => "Preston - Salon 3 ReXRe + 2XX",
                "type" => "indoor",
                "popular" => true,
                // "like" => true,
                "price" => 28,
                // "categories" => 'Sofa',
                "description" => "Zoekt u een oplossing voor de stress van alledag? Relax, want de « Preston » lounge met twee elektrische relaxers is uw bondgenoot! \n Deze prachtige stoffen lounge is verkrijgbaar in 3 kleuren: antraciet, lichtgrijs en bruin. \n De elektrische relaxfauteuils bevinden zich eerst op de driezitsbank. De tweezitsbank heeft ze niet. Het is mogelijk deze lounge te bestellen met meer elektrische relaxfauteuils (met name de tweezitsbank) als u wilt dat uw gasten samen met u van deze ongelooflijke ervaring genieten.",

                "description_fr" => "A la recherche d’une solution pour dégager le stress du quotidien ? Relaxez-vous, car le salon « Preston » doté de deux relax électriques est votre allié ! \n  Ce merveilleux salon en tissus existe en 3 couleurs ; anthracite, gris clair et brun. \n Les relax électriques se trouvent initialement sur le canapé de trois places. Le canapé de deux places n’en dispose pas. Il est possible de commander ce salon avec plus de relax électriques (notamment le canapé de deux places) si vous souhaitez que vos invités vivent avec vous cette expérience incroyable.",

                "description_en" => "Looking for a solution to relieve the stress of everyday life? Relax, because the « Preston »  lounge with two electric relaxers is your ally! \n This wonderful fabric lounge comes in 3 colors; charcoal, light grey and brown. \n The electric recliners are initially located on the three-seat sofa. The two-seater sofa does not have them. You can order this lounge with more electric recliners (especially the two-seater sofa) if you want your guests to enjoy this incredible experience with you.",

                "created_at" => now()
            ],
            [
                "name" => "mySalon",
                "type" => "indoor",
                // "img" => "img/innovaImg/salon-1.jfif",
                "popular" => true,
                // "like" => true,
                "price" => 1050,
                // "categories" => 'Sofa',
                "description" => 'NL lorem lorem lorem nl',
                "description_fr" => 'FR lorem lorem lorem nl',
                "description_en" => 'EN lorem lorem lorem nl',
                "created_at" => now()
            ],
            [
                "name" => "myChambre",
                "type" => "indoor",
                // "img" => "img/innovaImg/chambre-1.jfif",
                "popular" => true,
                // "like" => true,
                "price" => 350,
                // "categories" => 'Bed',
                "description" => 'NL lorem lorem lorem nl',
                "description_fr" => 'FR lorem lorem lorem nl',
                "description_en" => 'EN lorem lorem lorem nl',
                "created_at" => now()
            ],
            [
                "name" => "myChambre2",
                "type" => "indoor",
                // "img" => "img/innovaImg/chambre-1.jfif",
                "popular" => true,
                // "like" => true,
                "price" => 50,
                // "categories" => 'Bed',
                "description" => 'NL lorem lorem lorem nl',
                "description_fr" => 'FR lorem lorem lorem nl',
                "description_en" => 'EN lorem lorem lorem nl',
                "created_at" => now()
            ],
            [
                "name" => "myDecore",
                "type" => "outdoor",
                // "img" => "img/innovaImg/tapis.jfif",
                "popular" => true,
                // "like" => false,
                "price" => 750,
                // "categories" => 'Decore',
                "description" => 'NL lorem lorem lorem nl',
                "description_fr" => 'FR lorem lorem lorem nl',
                "description_en" => 'EN lorem lorem lorem nl',
                "created_at" => now()
            ],
            [
                "name" => "myTable",
                "type" => "outdoor",
                // "img" => "img/innovaImg/table.jfif",
                "popular" => false,
                // "like" => false,
                "price" => 350,
                // "categories" => 'Table',
                "description" => 'NL lorem lorem lorem nl',
                "description_fr" => 'FR lorem lorem lorem nl',
                "description_en" => 'EN lorem lorem lorem nl',
                "created_at" => now()
            ],
        ]);
    }
}
