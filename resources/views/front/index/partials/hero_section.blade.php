<!-- Hero Section-->
    <div id="index-slider" class="owl-carousel">
    @if($hero_posts->isNotEmpty())
     @foreach($hero_posts as $post)
      <section style="background: url('{{ $post->getImageUrl() }}'); background-size: cover; background-position: center center" class="hero">
        <div class="container">
          <div class="row">
            <div class="col-lg-7">
              <h1>{{ $post->heading }}</h1>
              <a href="{{ $post->url() }}" class="hero-link">Discover More</a>
            </div>
          </div>
        </div>
      </section>
     @endforeach
    @else
        <p>No featured posts available.</p>
    @endif
    </div>

