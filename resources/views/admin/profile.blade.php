@extends('admin._layout._layout')

@section('content')
<div class="container"  style="background-color: #FCFBF4;">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4 text-center">
           @if($user->getImageUrl())
            <img src="{{ $user->getImageUrl() }}" class="rounded-circle mb-3" alt="{{ $user->name }}" style="width: 280px; height: 280px; object-fit: cover;">
           @else
                <img src="{{ url('/themes/front/img/cube_1test.jpg') }}" class="rounded-circle mb-3" alt="Default Profile" style="width: 280px;">
           @endif
           
            <h1>{{ $user->name }}</h1>
            @if($user->email)
                <p class="text-muted" style="font-size: 1.25rem;">{{ $user->email }}</p>
            @else
                <p class="text-muted" style="font-size: 1.25rem;">No email provided</p>
            @endif
        </div>
    </div>
</div>
@endsection