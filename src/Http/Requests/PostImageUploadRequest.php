<?php

namespace MetaGameTechnologies\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostImageUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|image|mimes:jpeg,jpg,png,gif|max:1200'
        ];
    }
}
