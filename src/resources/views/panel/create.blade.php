@extends('vendor.metagame.blog.layout')

@section('content')
    <div class="my-5">
        <h2>New Post</h2>
        <post-form action="create" action-url="{{ route('blog.panel.store') }}"></post-form>
    </div>
@stop