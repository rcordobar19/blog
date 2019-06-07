<?php

namespace MetaGameTechnologies\Blog\Database\Seeds;

use Illuminate\Database\Seeder;
use MetaGameTechnologies\Blog\Models\PostCategory;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        foreach(config('blog.categories') as $category){
            $postCategory = new PostCategory;
            $postCategory->name = $category['name'];
            $postCategory->save();
        }
    }
}
