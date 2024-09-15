<!-- Modal -->
<div class="modal fade" id="add_service" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Pelayanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Nama Pelayanan</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" placeholder="Nama Pelayanan" autofocus>
                        @if ($errors->has('title'))
                            <span class="text-danger text-sm">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                            rows="3">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger text-sm">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="section-title">File Image</div>
                    <div class="custom-file">
                        <input type="file"
                            class="form-control-file form-control @error('name_photo') is-invalid @enderror"
                            id="name_photo" name="name_photo" accept=".jpg, .jpeg, .png">
                        @if ($errors->has('name_photo'))
                            <span class="text-danger text-sm">{{ $errors->first('name_photo') }}</span>
                        @endif
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
