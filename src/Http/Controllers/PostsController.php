<?php


namespace MetaGameTechnologies\Blog\Http\Controllers;


use Illuminate\Routing\Controller;
use MetaGameTechnologies\Blog\Models\Post;
use MetaGameTechnologies\Blog\Models\PostCategory;

class PostsController extends Controller
{
    public function getFeaturedPosts()
    {
        $data = Post::published()->featured()->get();

        return response()->json($data);
    }

    public function getLatestPosts($post_num = 10)
    {
        $data = Post::take($post_num)->published()->get();

        return response()->json($data);
    }

    public function getPost($slug)
    {
        $data['post'] = Post::whereSlug($slug)->with('categories')->first();

        $data['related'] = Post::take(3)->related($slug)->get();

        return $data;
    }

    public function getAllCategories()
    {
        $data = PostCategory::get();

        if($data->isEmpty()){
            return [];
        }

        return response()->json($data);
    }

    public function getPostsByCategories($category_id = 0)
    {
        if($category_id == 0) {
            $data['posts'] = Post::take(10)->published()->get();
        }else{
            $data['posts'] = Post::whereHas('categories', function($q) use($category_id) {
                $q->where('category_id', $category_id);
            })->get();
        }

        return $data;
    }
}