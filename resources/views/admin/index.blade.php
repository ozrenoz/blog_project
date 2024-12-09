@extends('admin._layout._layout')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                
                <a href="{{ $top_post->url() }}">
                     <img src="{{ $top_post->getImageUrl() }}" class="card-img-top w-100 rounded shadow mb-4" alt="{{ $top_post->heading }}" style="height: 75vh; object-fit: cover;">
                </a>
                <div class="card-body">
                    <h3>Most Popular Post:</h3>
                    <h3 class="card-title">
                        <a href="{{ $top_post->url() }}" class="text-dark">{{ $top_post->heading }}</a>
                    </h3>
                    <p class="text-muted">
                        By <a href="{{ $top_post->author->url() }}">{{ $top_post->author->name }}</a> | {{ number_format($top_post->views) }} Views
                    </p>
                    <p class="card-text">{{ $top_post->post_description }}</p>
                    <p class="card-text text-truncate">{{ Str::limit($top_post->text, 150, '...') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>
                        Most Popular Category: 
                        <a href="{{ $top_category->url() }}" class="text-dark">{{ $top_category->name }}</a>
                    </h4>
                    <p class="text-muted">{{ $top_category->description }}</p>
                    <p>Total Views: {{ number_format($top_category->total_views) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>
                        Most Popular Author: 
                        <a href="{{ $top_author->url() }}" class="text-dark">{{ $top_author->name }}</a>
                    </h4>
                    
                    <a href="{{ $top_author->url() }}">
                        <img src="{{ $top_author->getImageUrl() }}" class="img-thumbnail mb-2" alt="{{ $top_author->name }}">
                    </a>
                    <p>Total Views: {{ number_format($top_author->total_views) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
