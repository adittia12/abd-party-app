<!-- Modal -->
<div class="modal fade" id="add_user" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user/add/save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" placeholder="Full Name">
                            @if ($errors->has('name'))
                                <span class="text-danger text-sm">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="Email">
                            @if ($errors->has('email'))
                                <span class="text-danger text-sm">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="role_name">Role Name</label>
                        <select id="role_name" class="form-control @error('role_name') is-invalid @enderror"
                            name="role_name" value="{{ old('role_name') }}">
                            <option selected disabled>Pilih Role Name</option>
                            @foreach ($role_name as $item)
                                <option value="{{ $item->role_type }}">{{ $item->role_type }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role_name'))
                            <span class="text-danger text-sm">{{ $errors->first('role_name') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone_number">Phone</label>
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                            placeholder="Number Phone">
                        @if ($errors->has('phone_number'))
                            <span class="text-danger text-sm">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="image">Upload Photo</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" value="{{ old('image') }}" accept="image/png, image/jpeg">
                        @if ($errors->has('image'))
                            <span class="text-danger text-sm">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" class="form-control @error('status') is-invalid @enderror"
                                name="status" value="{{ old('status') }}">
                                <option selected disabled>Pilih Status</option>
                                @foreach ($status_user as $item)
                                    <option value="{{ $item->type_name }}">{{ $item->type_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('status'))
                                <span class="text-danger text-sm">{{ $errors->first('status') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" value="{{ old('password') }}"
                                placeholder="Enter Password">
                            @if ($errors->has('password'))
                                <span class="text-danger text-sm">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label" for="password_confirmation">Repeat Password</label>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                value="{{ old('password_confirmation') }}" placeholder="Choose Repat Password">
                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger text-sm">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
