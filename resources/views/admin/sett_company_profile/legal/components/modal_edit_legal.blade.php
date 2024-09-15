<!-- Modal -->
<div class="modal fade" id="edit_legal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Legal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateLegal') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_update_legal" id="e_id_update_legal">
                    <div class="mb-3">
                        <label class="form-label" for="title">Nama Document</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="e_title"
                            name="title" placeholder="Nama Document">
                        @if ($errors->has('title'))
                            <span class="text-danger text-sm">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="document">Image</label>
                        <img id="image_preview" src="" alt="Image Preview" class="img-thumbnail mb-3"
                            style="display: none; max-width: 100px;">
                        <input type="file"
                            class="form-control-file form-control @error('document') is-invalid @enderror"
                            id="e_image" name="document" accept=".jpg, .jpeg, .png">
                        @if ($errors->has('document'))
                            <span class="text-danger text-sm">{{ $errors->first('document') }}</span>
                        @endif
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
