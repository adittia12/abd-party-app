<!-- Modal -->
<div class="modal fade" id="edit_client" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update_client') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="client_id" id="e_id_client">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="client_name">Nama Perusahaan</label>
                            <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                                id="e_client_name" name="client_name" placeholder="Nama Perusahaan">
                            @if ($errors->has('client_name'))
                                <span class="text-danger text-sm">{{ $errors->first('client_name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="image">Image</label>
                            <img id="image_preview" src="" alt="Image Preview" class="img-thumbnail mb-3"
                                style="display: none; max-width: 100px;">
                            <input type="file"
                                class="form-control-file form-control @error('image') is-invalid @enderror"
                                id="e_image" name="image" accept=".jpg, .jpeg, .png">
                            @if ($errors->has('image'))
                                <span class="text-danger text-sm">{{ $errors->first('image') }}</span>
                            @endif
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
