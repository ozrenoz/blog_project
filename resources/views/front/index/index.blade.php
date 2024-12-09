@extends('front._layout._layout')

@section('seo_title', 'Home')

@section('content')
     
     @include('front.index.partials.hero_section')

     @include('front.index.partials.intro_section')
     
     @include('front.index.partials.divider_section')
    
     @include('front.index.partials.latest_posts')
    
     @include('front.index.partials.gallery_section')
     
@endsection