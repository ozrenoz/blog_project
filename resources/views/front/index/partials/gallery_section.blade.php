<!-- Gallery Section-->
    <section class="gallery no-padding">    
        
     @if($four_gallery_posts->isNotEmpty())
      <div class="row">
          @foreach($four_gallery_posts as $post)
        <div class="mix col-lg-3 col-md-3 col-sm-6">
          <div class="item">
            <a href="{{$post->url()}}" data-fancybox="gallery" class="image">
              <img src="{{$post->getImageUrl()}}" alt="gallery image alt 1" class="img-fluid" title="gallery image title 1">
              <div class="overlay d-flex align-items-center justify-content-center"><i class="icon-search"></i></div>
            </a>
          </div>
        </div>
          @endforeach
      </div>
      @else
        <p>No gallery images available.</p>
      @endif
     
    </section>
