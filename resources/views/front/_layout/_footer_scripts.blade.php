<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>    

<script src="{{url('/themes/front/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{url('/themes/front/vendor/popper.js/umd/popper.min.js')}}"></script>
<script src="{{url('/themes/front/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{url('/themes/front/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
<script src="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{url('/themes/front/js/front.js')}}"></script>

@stack('footer_scripts')
@stack('contact_scripts')

<!-- owl carousel -->
<script src="{{url('/themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
<script>
$("#index-slider").owlCarousel({
"items": 1,
"loop": true,
"autoplay": true,
"autoplayHoverPause": true
});

$("#latest-posts-slider").owlCarousel({
"items": 1,
"loop": true,
"autoplay": true,
"autoplayHoverPause": true
});
</script>
