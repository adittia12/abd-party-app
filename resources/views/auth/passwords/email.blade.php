@extends('auth.layouts.master_auth')
@section('title')
    Forgot Password
@endsection

@section('content')
    <div class="container mt-5">
        @include('sweetalert::alert')
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                    <img src="{{ asset('admin/assets/img/stisla-fill.svg') }}" alt="logo" width="100"
                        class="shadow-light rounded-circle">
                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Forgot Password</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">We will send a link to reset your password</p>
                        <form method="POST" action="{{ route('forget-password') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" tabindex="1" placeholder="Enter your email" required
                                    autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Send
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mb-3">
                        Don't have an account? <a href='{{ route('login') }}'>Login</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
