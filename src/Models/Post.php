<?php

namespace MetaGameTechnologies\Blog\Models;

use MetaGameTechnologies\Blog\Presenters\PostPresenter;
use Illuminate\Database\Eloquent\Model;
use Robbo\Presenter\PresentableInterface;

class Post extends Model implements PresentableInterface
{
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'content',
        'post_image',
        'preview_image',
        'featured',
        'published',
        'published_at',
        'created_at',
    ];

    protected $dates = ['created_at', 'updated_at', 'published_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPresenter()
    {
        return new PostPresenter($this);
    }

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'category_post', 'post_id', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('published', true)->latest('published_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeRelated($query, $slug)
    {
        return $query->where('published', true)->latest('published_at')->where('slug', '!=', $slug);
    }
}
