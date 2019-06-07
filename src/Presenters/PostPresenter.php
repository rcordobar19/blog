<?php


namespace MetaGameTechnologies\Blog\Presenters;


use Robbo\Presenter\Presenter;

class PostPresenter extends Presenter
{
    public function created_at()
    {
        return $this->created_at->format('M j\\, y \\- h:i a');
    }

    public function published_at()
    {
        if(! $this->published || $this->published_at == null) {
            return false;
        }

        return $this->published_at->diffForHumans();
    }

    public function author()
    {
        return $this->author->name;
    }

    public function presentisFeatured()
    {
        if($this->featured){
            return 'Yes';
        }
    }
}