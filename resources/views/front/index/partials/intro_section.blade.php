<!-- Intro Section-->
     <section class="intro">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <h2 class="h3">Wise thoughts</h2>
            <p class="text-big">You never <strong>finish a program</strong>, you just stop <strong>working on it.</strong>.</p>
          </div>
        </div>
      </div>
    </section>
   <section class="featured-posts no-padding-top">
    <div class="container">
        <!-- Post -->
       @if($important_posts->isNotEmpty())
        @foreach ($important_posts as $index => $post)
            <div class="row d-flex align-items-stretch {{ $index % 2 == 1 ? 'flex-row-reverse' : '' }}">
                <div class="image col-lg-5"><img src="{{$post->getImageUrl()}}" alt="..."></div>
                <div class="text col-lg-7">
                    <div class="text-inner d-flex align-items-center">
                        <div class="content">
                            <header class="post-header">
                                <div class="category"><a href="{{$post->category->url()}}">{{ $post->category->name }}</a></div>
                                <a href="{{$post->url()}}">
                                    <h2 class="h4">{{ $post->heading }}</h2>
                                </a>
                            </header>
                            <p>{{ Str::limit($post->post_description, 150, '...') }}</p>
                            <footer class="post-footer d-flex align-items-center">
                                <a href="{{$post->author->url()}}" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="{{$post->author->getImageUrl()}}" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>{{ $post->author->name }}</span></div>
                                </a>
                                <div class="date"><i class="icon-clock"></i> {{ $post->created_at->diffForHumans() }}</div>
                                <div class="comments"><i class="icon-comment"></i>{{ $post->comments->count() }}</div>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
       @else
            <p>No posts available.</p>
       @endif
    </div>
</section>


