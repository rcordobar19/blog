<?php

namespace MetaGameTechnologies\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'category_post', 'category_id', 'post_id');
    }
}
