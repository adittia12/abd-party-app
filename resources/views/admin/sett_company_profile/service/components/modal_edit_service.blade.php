<!-- Modal -->
<div class="modal fade" id="edit_service" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update_service') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_updateservice" id="e_id_updateservice">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="e_title"
                            name="title" placeholder="Nama Perusahaan">
                        @if ($errors->has('title'))
                            <span class="text-danger text-sm">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="slug">Slug</label>
                        <input type="text" class="form-control" name="slug_service" id="e_slug_service">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="e_description"
                            rows="3">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger text-sm">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="image">Image</label>
                        <img id="image_preview" src="" alt="Image Preview" class="img-thumbnail mb-3"
                            style="display: none; max-width: 100px;">
                        <input type="file"
                            class="form-control-file form-control @error('name_photo') is-invalid @enderror"
                            id="e_image" name="name_photo" accept=".jpg, .jpeg, .png">
                        @if ($errors->has('name_photo'))
                            <span class="text-danger text-sm">{{ $errors->first('name_photo') }}</span>
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
