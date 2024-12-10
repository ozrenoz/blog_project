@extends('front._layout._layout')

@section('seo_title', $post->heading)

@section('content')
 <div class="container">
      <div class="row">
        <main class="post blog-post col-lg-8"> 
          <div class="container">
            <div class="post-single">
             <!-- Post -->
              <div class="post-thumbnail">
                 @if($post->getImageUrl())
                    <img src="{{ $post->getImageUrl() }}" alt="..." class="img-fluid">
                 @else
                    <img src="{{ url('/themes/front/img/cube_1test.jpg') }}" alt="Default Image" class="img-fluid">
                 @endif
              </div>
              <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                  <div class="category"><a href="{{$category->url()}}">{{$category->name}}</a></div>
                </div>
                <h1>{{$post->heading}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="{{$author->url()}}" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{$author->getImageUrl()}}" alt="..." class="img-fluid"></div>
                    <div class="title"><span>{{$author->name}} {{$author->last_name}}</span></div></a>
                  <div class="d-flex align-items-center flex-wrap">       
                    <div class="date"><i class="icon-clock"></i> {{ $post->created_at->diffForHumans() }}</div>
                    <div class="views"><i class="icon-eye"></i> {{$post->views}}</div>
                    <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{ count($post->comments)}}</a></div>
                  </div>
                </div>
                <div class="post-body">
                  <p class="lead">{{ $textParts[0] ?? '' }}</p>
                  <p>{{ $textParts[1] ?? '' }}</p>
                  <p> <img src="{{url('/themes/front/img/featured-pic-3.jpeg')}}" alt="..." class="img-fluid"></p>
                  <h3>{{$post->post_description}}</h3>
                  <p>{{ $textParts[2] ?? '' }}</p>
                  <blockquote class="blockquote">
                    <p>{{ $textParts[3] ?? '' }}</p>
                    <footer class="blockquote-footer">
                      <cite title="Source Title">{{ $randomName ?? '' }}</cite>
                    </footer>
                  </blockquote>
                  <p>{{ $textParts[4] ?? '' }}</p>
                </div>
                <div class="post-tags">@foreach($post->tags as $tag)<a href="{{$tag->url()}}" class="tag">#{{$tag->name}}</a>@endforeach</div>
                <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                    <!-- Previous Post -->
                    @if ($previous)
                    <a href="{{ route('post', $previous->id) }}" class="prev-post text-left d-flex align-items-center">
                    <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                    <div class="text"><strong class="text-primary">Previous Post </strong>
                      <h6>{{ $previous->heading }}</h6>
                    </div></a>@endif
                    <!-- Next Post -->
                    @if ($next)
                    <a href="{{ route('post', $next->id) }}" class="next-post text-right d-flex align-items-center justify-content-end">
                    <div class="text"><strong class="text-primary">Next Post </strong>
                      <h6>{{ $next->heading }}</h6>
                    </div>
                    <div class="icon next"><i class="fa fa-angle-right">   </i></div></a>@endif</div>
                <!-- Comments -->
                <div class="post-comments" id="post-comments">
                  <header>
                    @if($post->comments)
                    <h3 class="h6">Post Comments<span class="no-of-comments">({{ count($post->comments)}})</span></h3>
                  </header>
                    @foreach($post->comments as $comment)
                  <div class="comment">
                    <div class="comment-header d-flex justify-content-between">
                      <div class="user d-flex align-items-center">
                        <div class="image"><img src="{{url('/themes/front/img/user.svg')}}" alt="..." class="img-fluid rounded-circle"></div>
                        <div class="title"><strong>{{ $comment->name }}</strong><span class="date">{{ $comment->created_at->format('F Y') }}</span></div>
                      </div>
                    </div>
                    <div class="comment-body">
                      <p>{{ $comment->message }}</p>
                    </div>
                  </div>
                     @endforeach
                   @endif
                </div>
                <div class="container">
                  <header>
                    <h3 class="h6">Leave a reply</h3>
                  </header>
                   <!-- Comment Form -->
                  <div id="message-area"></div> 
                  <form id="leave-comment-form" method="post" action="{{route('store_comment')}}" class="commenting-form">
                        @csrf
                    <div class="row">
                      <div class="form-group col-md-6">
                        <input value='' type="text" name="name" id="name" placeholder="Name" class="form-control">
                      <div class="invalid-feedback"></div>
                      </div>
                      <div class="form-group col-md-6">
                        <input value='' type="email" name="email" id="email" placeholder="Email Address (will not be published)" class="form-control">
                        <div class="invalid-feedback"></div>
                      </div>
                      <div class="form-group col-md-12">
                        <textarea name="message" id="message" placeholder="Type your comment" class="form-control" rows="14"></textarea>
                        <div class="invalid-feedback"></div>
                      </div>
                      <input type="hidden" name="post_id" value="{{$post->id}}">
                      <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-secondary">Submit Comment</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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

<!-- Comment Form validation & Submit -->
@push('footer_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script>
$(document).ready(function(){
    $('#leave-comment-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 30
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true,
                minlength: 10,
                maxlength: 500
            }
        },
        messages: {
            name: {
                required: "Please enter your name!",
                minlength: "Your name must be over 2 characters!",
                maxlength: "Enter no more than 50 characters!"
            },
            email: {
                required: "Your email address must be provided!",
                email: "Enter valid email address!"
            },
            message: {
                required: "What do you want to say to us?",
                minlength: "Your message must be longer than 10 characters!",
                maxlength: "Your message cannot be longer than 250 characters!"
            }
        },
        errorClass: "is-invalid"
    });
    //submit comment
      $('#leave-comment-form').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('store_comment') }}",
            type: 'post',
            data: $(this).serialize(),
            success: function(data) {
                $('#leave-comment-form')[0].reset(); // Clear the form
                $('#message-area').html('<div class="alert alert-success">' + data.message + '</div>'); // Display success message
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, message) {
                    var input = '#leave-comment-form [name="' + key + '"]';
                    $(input).addClass('is-invalid').next('.invalid-feedback').text(message[0]); // Display validation messages
                });
            }
        });
    });
    
});
</script>
@endpush
