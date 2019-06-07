<?php


namespace MetaGameTechnologies\Blog\Http\Controllers;


use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('vendor.metagame.blog.index');
    }

    public function show($slug)
    {
        return view('vendor.metagame.blog.show', compact('slug', $slug));
    }
}