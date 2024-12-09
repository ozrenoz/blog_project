 <!-- Latest Posts -->
    <section class="latest-posts"> 
      <div class="container">
        <header> 
          <h2>Latest from the blog</h2>
          <p class="text-big">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
        </header>
        <div class="owl-carousel" id="latest-posts-slider">
         <!-- koristim metodu chunk() kako bih grupisao postove u trojke zbog smenjivanja u carousel-u -->
       @if($latest_12_posts->isNotEmpty())
         @foreach ($latest_12_posts->chunk(3) as $chunk)
          <div class="row">
           @foreach ($chunk as $post)
            <div class="post col-md-4">
              <div class="post-thumbnail"><a href="{{$post->url()}}"><img src="{{$post->getImageUrl()}}" alt="..." class="img-fluid"></a></div>
              <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                  <div class="date">{{\Carbon\Carbon::parse($post->created_at)->format('M d, Y')}}</div>
                  <div class="category"><a href="{{$post->category->url()}}">{{$post->category->name}}</a></div>
                </div><a href="{{$post->url()}}">
                  <h3 class="h4">{{$post->heading}}</h3></a>
                <p class="text-muted">{{$post->post_description}}</p>
              </div>
            </div>
           @endforeach
          </div>
        @endforeach
       @else
           <p>No latest posts available.</p>
       @endif
        </div>
      </div>
    </section>
