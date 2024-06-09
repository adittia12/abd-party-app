@extends('frontend.layout.master')
@section('title')
    Change Password
@endsection

@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Change Password</h1>
        </div>
        <div class="row">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Change password</h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-3">
                                <form method="POST" action="{{ route('change/password/db') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Old Password</label>
                                        <input
                                            class="form-control form-control-lg @error('current_password') is-invalid @enderror"
                                            value="{{ old('current_password') }}" type="password" name="current_password"
                                            placeholder="Enter your Old Password" />
                                        @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input
                                            class="form-control form-control-lg @error('new_password') is-invalid @enderror"
                                            value="{{ old('new_password') }}" type="password" name="new_password"
                                            placeholder="Enter your New Password" />
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input
                                            class="form-control form-control-lg @error('new_confirm_password') is-invalid @enderror"
                                            value="{{ old('new_confirm_password') }}" type="password"
                                            name="new_confirm_password" placeholder="Choose Confirm Password" />
                                        @error('new_confirm_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button class="btn btn-primary account-btn" type="submit">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
