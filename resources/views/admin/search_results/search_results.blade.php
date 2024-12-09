@extends('admin._layout._layout')

@section('content')
<div class="container mt-4">
    <h2>Search Results for "{{ $query }}"</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3>Posts</h3>
    @if($posts->isEmpty())
        <p>No posts found.</p>
    @else
    <!-- Found Posts -->
        <ul>
            @foreach($posts as $post)
                <li>
                    <a href="{{ $post->url() }}">{{ $post->heading }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h3>Authors</h3>
    @if($authors->isEmpty())
        <p>No authors found.</p>
    @else
       <!-- Found Authors -->
        <ul>
            @foreach($authors as $author)
                <li>
                    <a href="{{ $author->url() }}">{{ $author->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection

