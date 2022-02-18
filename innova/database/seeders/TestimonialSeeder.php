<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('testimonials')->insert([
            [
                'img' => "salon-3.jpg",
                "etoile" => 5,
                "avis" => "This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.",
                "user" => "Jean David",
                "created_at" => now()
            ],
            [
                'img' => "salon-3.jpg",
                "etoile" => 4,
                "avis" => "This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.",
                "user" => "Luc Stavo",
                "created_at" => now()
            ],


        ]);
          DB::table('testimonials')->insert([
            [
                "etoile" => 4,
                "avis" => "This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, quis quaerat. Alias maiores aut odio?",
                "user" => "Emilie Loise",
                "created_at" => now()
            ],
            [
                "etoile" => 5,
                "avis" => "This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae, quis quaerat. Alias maiores aut odio?",
                "user" => "Ayhan Caliskan",
                "created_at" => now()
            ],


        ]);
    }
}
