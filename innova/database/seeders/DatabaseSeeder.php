<?php

namespace Database\Seeders;


use App\Models\Categories;
use App\Models\Specification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ProductSeeder::class,
            CommentSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SpecificationSeeder::class,
            CategoriesSeeder::class,
            Category_ProductSeeder::class,
            ImageSeeder::class,
            FaqSeeder::class,
            TestimonialSeeder::class,
            AboutSeeder::class,
            PartenerSeeder::class,
            CategoFrSeeder::class,
            CategoEnSeeder::class,
            InstaSeeder::class,
        ]);
    }
}
