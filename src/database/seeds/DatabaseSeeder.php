<?php

namespace MetaGameTechnologies\Blog\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         $this->call(BlogAdminSeeder::class);
         $this->call(CategoriesSeeder::class);
//         $this->call(PostSeeder::class);
    }
}
