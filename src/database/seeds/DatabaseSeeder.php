<?php

namespace MetaGameTechnologies\Blog\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         $this->call(PostSeeder::class);
         $this->call(CategoriesSeeder::class);
    }
}
