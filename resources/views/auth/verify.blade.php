@extends('auth.layouts.master_auth')

@section('content')
    <div class="container">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Reset Password</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted">Click Reset Password</p>
                    <a href="{{ url('/reset-password/' . $token) }}">Click Here</a>
                </div>
            </div>
        </div>
    </div>
@endsection
