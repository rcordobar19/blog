<?php

namespace MetaGameTechnologies\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required|min:3',
            'slug' => 'required|min:3',
            'title' => 'required|min:3',
            'categories' => 'required',
        ];
    }
}
