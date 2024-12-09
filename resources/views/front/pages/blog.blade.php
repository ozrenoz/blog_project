@extends('front._layout._layout')

@section('seo_title', 'Blog')

@section('content')
 <div class="container">
      <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
          <div class="container">
            <div class="row">
              <!-- post -->
             @if($latest_twelve_posts->isNotEmpty())
              @foreach($latest_twelve_posts as $post)
              <div class="post col-xl-6">
                <div class="post-thumbnail"><a href="{{$post->url()}}"><img src="{{ $post->getImageUrl() }}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                  <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">{{\Carbon\Carbon::parse($post->created_at)->format('M d, Y')}}</div>
                    <div class="category"><a href="{{optional($post->category)->url()}}">{{$post->category->name}}</a></div>
                  </div><a href="{{$post->url()}}">
                    <h3 class="h4">{{$post->heading}}</h3></a>
                  <p class="text-muted">{{$post->post_description}}</p>
                  <footer class="post-footer d-flex align-items-center"><a href="{{$post->author->url()}}" class="author d-flex align-items-center flex-wrap">
                      <div class="avatar"><img src="{{$post->author->getImageUrl()}}" alt="..." class="img-fluid"></div>
                      <div class="title"><span>{{$post->author->name}}</span></div></a>
                    <div class="date"><i class="icon-clock"></i> {{ $post->created_at->diffForHumans() }}</div>
                    <div class="comments meta-last"><i class="icon-comment"></i>{{ count($post->comments)}}</div>
                  </footer>
                </div>
              </div>
              @endforeach
             @else
                <p>No posts available.</p>
             @endif
              
            
            <!-- Pagination -->
            <!--Dodao sam ovu klasu da bi mi paginacija zauzela centriranu poziciju(relativno u odnosu  na segment stranice),
            nalazi se u themes\front\css\style.default.css. Takodje sam sklonio i ono koliko postova je prikazano, 
            nije mi se svidelo kako izgleda, kod sam izmenio u resources\views\vendor\pagination\bootstrap-5.blade.php-->
          
            <nav class="pagination custom-pagination">
                {{ $latest_twelve_posts->onEachSide(1)->links() }}
           </nav>
           
          
          </div>
        </main>
        <aside class="col-lg-4">
          <!-- Widget [Search Bar Widget]-->
          <div class="widget search">
            <header>
              <h3 class="h6">Search the blog</h3>
            </header>
            <form action="{{ route('search') }}" method="GET" class="search-form">
              <div class="form-group">
                <input type="search" name="query" placeholder="What are you looking for?" required>
                <button type="submit" class="submit"><i class="icon-search"></i></button>
              </div>
            </form>
          </div>
          <!-- Widget [Latest Posts Widget]        -->
          <div class="widget latest-posts">
            <header>
              <h3 class="h6">Latest Posts</h3>
            </header>
           @if($mvlm_posts->isNotEmpty())
            <div class="blog-posts">
                <!-- Most viewed last month posts -->
                @foreach($mvlm_posts as $post)
                <a href="{{ $post->url() }}">
              <div class="item d-flex align-items-center">
                <div class="image"><img src="{{$post->getImageUrl()}}" alt="..." class="img-fluid"></div>
                <div class="title"><strong>{{ $post->heading }}</strong>
                  <div class="d-flex align-items-center">
                    <div class="views"><i class="icon-eye"></i> {{ $post->views }}</div>
                    <div class="comments"><i class="icon-comment"></i>{{ count($post->comments)}}</div>
                  </div>
                </div>
              </div></a>
                @endforeach
            </div>
             @else
                <p>No posts available.</p>
             @endif
          </div>
          <!-- Widget [Categories Widget]-->
          <div class="widget categories">
            <header>
              <h3 class="h6">Categories</h3>
            </header>
          @if($categories_for_display->isNotEmpty())
           @foreach($categories_for_display as $category)
            <div class="item d-flex justify-content-between"><a href="{{ $category->url()}}">{{$category->name}}</a><span>{{$category->count()}}</span></div>
           @endforeach
          @else
            <p>No categories available.</p>
          @endif
          </div>
          <!-- Widget [Tags Cloud Widget]-->
          <div class="widget tags">       
            <header>
              <h3 class="h6">Tags</h3>
            </header>
           @if($all_tags->isNotEmpty())
            <ul class="list-inline">
               @foreach($all_tags as $tag)
                    <li class="list-inline-item"><a href="{{ $tag->url() }}" class="tag">#{{ $tag->name }}</a></li>
              @endforeach
            </ul>
           @else
               <p>No tags available.</p>
           @endif
          </div>
        </aside>
      </div>
    </div>

@endsection

