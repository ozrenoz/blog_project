<!DOCTYPE html>
<html lang="en">
@include('admin._layout._head')

<body class="sb-nav-fixed">
    @include('admin._layout._navbar')
    @include('admin._layout._sidebar')
    <div id="layoutSidenav_content">
    <main>
        @yield('content')
    </main>
</body>
@include('admin._layout._footer')
</html>
