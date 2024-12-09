<footer class="main-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="logo">
              <h6 class="text-white">Bootstrap Blog</h6>
            </div>
            <!-- contact details -->
            <div class="contact-details">
              <p>53 Broadway, Broklyn, NY 11249</p>
              <p>Phone: (020) 123 456 789</p>
              <p>Email: <a href="mailto:info@company.com">Info@Company.com</a></p>
              <!-- social menu -->
              <ul class="social-menu">
                <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-behance"></i></a></li>
                <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <!-- main pages footer list -->  
            <div class="menus d-flex">
              <ul class="list-unstyled">
                <li> <a href="{{route('index')}}">Home</a></li>
                <li> <a href="{{route('blog')}}">Blog</a></li>
                <li> <a href="{{route('contact_us_page')}}">Contact</a></li>
                <li> <a href="{{route('login')}}">Login</a></li>
              </ul>
             <!-- categories footer list -->
             @if(isset($categories_for_display) && $categories_for_display->count())
              <ul class="list-unstyled">
                  @foreach($categories_for_display->slice(0, 4) as $category)
                       <li> <a href="{{ $category->url()}}">{{ $category->name }}</a></li>
                  @endforeach
              </ul>
             @endif
            </div>
          </div>
          <div class="col-md-4">
            <!-- latest posts footer -->
           @if($latest_posts->isNotEmpty())
            <div class="latest-posts">
                @foreach($latest_posts as $post)
                
                <a href="{{ $post->url() }}">
                <div class="post d-flex align-items-center">
                  <div class="image"><img src="{{$post->getImageUrl()}}" alt="..." class="img-fluid"></div>
                  <div class="title"><strong>{{ $post->heading }}</strong><span class="date last-meta">{{ \Carbon\Carbon::parse($post->created_at)->format('M d, Y') }}</span></div>
                </div></a>@endforeach</div>
          </div>
            @else
               <p>No posts available.</p>
            @endif
        </div>
      </div>
      <div class="copyrights">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <p>&copy; 2017. All rights reserved. Your great site.</p>
            </div>
            <div class="col-md-6 text-right">
              <p>Template By <a href="https://bootstrapious.com/p/bootstrap-carousel" class="text-white">Bootstrapious</a>
                <!-- Please do not remove the backlink to Bootstrap Temple unless you purchase an attribution-free license @ Bootstrap Temple or support us at http://bootstrapious.com/donate. It is part of the license conditions. Thanks for understanding :)                         -->
              </p>
            </div>
          </div>
        </div>
      </div>
    </footer>
