<!-- Modal -->
<div class="modal fade" id="edit_user" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="e_id">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control" id="e_name" name="name" value=""
                                placeholder="Full Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="text" class="form-control" id="e_email" name="email" value=""
                                placeholder="Email">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="role_name">Role Name</label>
                        <select class="select form-control" name="role_name" id="e_role_name">
                            @foreach ($role_name as $role)
                                <option value="{{ $role->role_type }}">{{ $role->role_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone_number">Phone</label>
                        <input type="tel" class="form-control" id="e_phone_number" name="phone" value=""
                            placeholder="Number Phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="image">Upload Photo</label>
                        <input type="file" class="form-control" id="image" name="images" value=""
                            accept="image/png, image/jpeg">
                        <input type="hidden" name="hidden_image" id="e_image" name="image">
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-5">
                            <label class="form-label" for="status">Status</label>
                            <select id="e_status" class="form-control selected" name="status" value="">
                                @foreach ($status_user as $item)
                                    <option value="{{ $item->type_name }}">{{ $item->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
