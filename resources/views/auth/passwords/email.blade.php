@extends('auth._layout._layout')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                    <div class="card-body">
                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label for="inputEmail">Email address</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small" href="{{route('login')}}">Return to login</a>
                                <button class="btn btn-primary" type='submit'>Reset Password</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection