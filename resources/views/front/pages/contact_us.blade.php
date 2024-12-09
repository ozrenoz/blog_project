@extends('front._layout._layout')

@section('seo_title', 'Contact us')

@section('content')

<!-- Hero Section -->
    <section style="background: url(/themes/front/img/hero.jpg); background-size: cover; background-position: center center" class="hero">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h1>Have an interesting news or idea? Don't hesitate to contact us!</h1>
          </div>
        </div>
      </div>
    </section>
    <div class="container">
      <div class="row">
        <main class="col-lg-8"> 
          <div class="container">
                @if(session()->has('system_message'))
                <div class="alert alert-success" role="alert">
                    {{session()->pull('system_message')}}
                </div>
                @endif
                
                @error('captcha')
                   <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              <!-- Contact Form -->  
              <form id='contact-us-form' action="{{route('contact_us_form_upload')}}" method="post" class="commenting-form">
                  @csrf
              <div class="row">
                <div class="form-group col-md-6">
                    <input type="text" name="name" placeholder="Your Name" class="form-control" value="{{old('name')}}">
                     @error('name')
                         <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
                <div class="form-group col-md-6">
                    <input type="email" name="email" placeholder="Email Address (will not be published)" class="form-control" value="{{old('email')}}">
                     @error('email')
                         <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
                <div class="form-group col-md-12">
                    <textarea name="message" placeholder="Type your message" class="form-control" rows="20">{{old('message')}}</textarea>
                     @error('message')
                         <div class="alert alert-danger">{{ $message }}</div>
                     @enderror
                </div>
                <div class="g-recaptcha form-group col-md-12" data-sitekey="6LfU_k0qAAAAAO0ZX2VMLTn8f-aaNbyoLa87QCju"></div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-secondary">Submit Your Message</button>
                </div>
              </div>
            </form>
          </div>
        </main>
        <aside class="col-lg-4">
          <!-- Widget [Contact Widget]-->
          <div class="widget categories">
            <header>
              <h3 class="h6">Contact Info</h3>
              <div class="item d-flex justify-content-between">
                <span>15 Yemen Road, Yemen</span>
                <span><i class="fa fa-map-marker"></i></span>
              </div>
              <div class="item d-flex justify-content-between">
                <span>(020) 123 456 789</span>
                <span><i class="fa fa-phone"></i></span>
              </div>
              <div class="item d-flex justify-content-between">
                <span>info@company.com</span>
                <span><i class="fa fa-envelope"></i></span>
              </div>
            </header>
            
          </div>
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
        </aside>
      </div>
    </div>
@endsection
<!-- Contact Form Validation -->
@push('footer_scripts')
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

 <script>
        $(document).ready(function(){
            $('#contact-us-form').validate({
                "rules" : {
                    "name" : {
                        "required" : true,
                        "minlength" : 2,
                        "maxlength" : 30
                    },
                    "email" : {
                        "required" : true,
                        "email" : true
                    },
                    "message" : {
                        "required" : true,
                        "minlength" : 10,
                        "maxlength" : 500
                    }
                },
                "messages" : {
                    "name" : {
                        "required" : "Please enter your name!",
                        "minlength" : "Your name must be over 2 characters!",
                        "maxlength" : "Enter no more than 30 characters!"
                    },
                    "email" : {
                        "required" : "Your email address must be provided!",
                        "email" : "Enter valid email address!"
                    },
                    "message" : {
                        "required" : "What do you want to say to us?",
                        "minlength" : "Your message must be longer than 10 characters!",
                        "maxlength" : "Your message cannot be longer than 500 characters!"
                    }
                },
                "errorClass" : "is-invalid"
            });
        });
    </script>
 
 @endpush
 
 <!-- Recaptcha -->
 @push('contact_scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 @endpush