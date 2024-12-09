<!DOCTYPE html>
<html>
    <head>
        @include('front._layout._head')
    </head>
    <body>
        @include('front._layout._navbar')

            @yield('content')
            
        @include('front._layout._footer')
        @include('front._layout._footer_scripts')
    </body>
</html>

