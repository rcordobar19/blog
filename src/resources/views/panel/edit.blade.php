@extends('vendor.metagame.blog.layout')

@section('content')
    <div class="container">
        <div class="my-5">
            <h2>Edit Post</h2>
            <post-form :post="{{ $post->toJson() }}" action="edit"></post-form>
        </div>
    </div>
@stop