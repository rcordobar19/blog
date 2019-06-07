<?php

namespace MetaGameTechnologies\Blog\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use MetaGameTechnologies\Blog\Http\Middleware\IsAdmin;
use MetaGameTechnologies\Blog\Http\Requests\PostRequest;
use MetaGameTechnologies\Blog\Models\Post;
use MetaGameTechnologies\Blog\Traits\HasImageUploads;

class AdminPanelController extends Controller
{
    use HasImageUploads;

    public function __construct()
    {
        $this->middleware(IsAdmin::class);
    }

    public function index()
    {
        $data['posts'] = Post::with(['author'])->get();

        return view('vendor.metagame.blog.panel.index', $data);
    }

    public function create()
    {
        return view('vendor.metagame.blog.panel.create');
    }

    public function store(PostRequest $request)
    {
        if($request->published){
            $request['published_at'] = Carbon::now();
        }

        $categoriesId = collect($request->categories)->pluck('id');

        $newPost = Post::create($request->all() + ['author_id' => Auth::id()]);
        $newPost->categories()->sync($categoriesId);

        return response()->json([
            'data' => $newPost,
            'message' => __('Post Created Successfully.'),
        ]);
    }

    public function edit($post)
    {
        $data['post'] = Post::whereSlug($post)->with('categories')->first();

        return view('vendor.metagame.blog.panel.edit', $data);
    }

    public function update($id, PostRequest $request)
    {
        if($request->published){
            $request['published_at'] = Carbon::now();
        }

        $categoriesId = collect($request->categories)->pluck('id');

        $post = Post::findOrFail($id);
        $post->update($request->all());
        $post->categories()->sync($categoriesId);

        return response()->json([
            'data' => $post,
            'message' => 'Post Updated Successfully',
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', __('Post Deleted.'));
    }
}
