@extends('auth.layouts.master_auth')

@section('title')
    Reset Password | ABD
@endsection

@section('content')
    <div class="container">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="{{ asset('admin/assets/img/logo_abd-removebg-preview.png') }}" alt="logo" width="300"
                    class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Reset Password</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted">We will send a link to reset your password</p>
                    <form method="POST" action="/reset-password">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Enter your email" tabindex="1"
                                required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" type="password"
                                class="form-control pwstrength @error('password') is-invalid @enderror"
                                data-indicator="pwindicator" name="password" placeholder="Enter your password"
                                tabindex="2" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                tabindex="2" placeholder="Choose repeat password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
                <div class="text-center mb-3">
                    Already have an account? <a href='{{ route('login') }}'>Login</a>
                </div>
            </div>
        </div>
    @endsection
