@extends('vendor.metagame.blog.layout')

@section('content')
    <div class="mt-5">
        <div class="mb-3">
            <a href="{{ route('blog.panel.create') }}" class="btn btn-outline-info">Create a new Post</a>
        </div>

        @if (\Session::has('success'))
            <div class="alert alert-success mb-3" role="alert">
                {!! \Session::get('success') !!}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col" class="table-head-text"></th>
                    <th scope="col" class="table-head-text">Title</th>
                    <th scope="col" class="table-head-text">Categories</th>
                    <th scope="col" class="table-head-text">Feature</th>
                    <th scope="col" class="table-head-text">Author</th>
                    <th scope="col" class="table-head-text">Published</th>
                    <th scope="col" class="table-head-text">Since</th>
                    <th scope="col" class="table-head-text"></th>
                </tr>
                </thead>
                <tbody class="table-body">
                @foreach ($posts as $post)
                    <tr>
                        <th>
                            <div style="width: 120px">
                                <img src="{{ $post->preview_image ?? asset('vendor/blog/images/default/post-preview.png') }}" alt="{{ $post->title }}" class="img-fluid">
                            </div>
                        </th>
                        <td>
                            <a href="{{ URL::to('blog', $post->slug) }}">{{ $post->title }}</a>
                        </td>
                        <td>
                            @foreach ($post->categories as $category)
                                {{ $category->name }}
                            @endforeach
                        </td>
                        <td>
                            @if($post->is_featured)
                                <span style="color: #38c172;">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            @else
                                <span style="color: #e3342f;">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </td>
                        <td>{{ $post->author() }}</td>
                        <td>
                            @if($post->published_at())
                                {{ $post->published_at() }}
                            @else
                                <span style="color: #e3342f;">
                                    <i class="fas fa-times"></i>
                                </span>
                            @endif
                        </td>
                        <td>{{ $post->created_at() }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <div class="mr-2">
                                    <a href="{{ URL::to('blog', $post->slug) }}" class="mr-3" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                                <div class="mr-2">
                                    <a href="{{ route('blog.panel.edit', $post->slug) }}" class="mr-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div>
                                    <form method="POST" action="{{ route('blog.panel.destroy', $post->slug) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button class="p-0" style="border: none;background: transparent">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop