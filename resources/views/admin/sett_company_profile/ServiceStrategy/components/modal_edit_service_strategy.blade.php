<!-- Modal -->
<div class="modal fade" id="edit_service_strategy" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Strategi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateServiceStrategy') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_update_serviceStrategy" id="e_id_update_serviceStrategy">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="e_title"
                            name="title" placeholder="Judul Strategi ">
                        @if ($errors->has('title'))
                            <span class="text-danger text-sm">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="e_description"
                            cols="30" rows="10"></textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger text-sm">{{ $errors->first('description') }}</span>
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
