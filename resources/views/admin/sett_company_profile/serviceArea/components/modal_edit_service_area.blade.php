<!-- Modal -->
<div class="modal fade" id="edit_service_area" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Wilayah Pelayanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('update_service_area') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_updateServiceArea" id="e_id_updateServiceArea">
                    <div class="mb-3">
                        <label class="form-label" for="area">Nama Wilayah</label>
                        <input type="text" class="form-control @error('area') is-invalid @enderror" id="e_area"
                            name="area" placeholder="Nama Wilayah">
                        @if ($errors->has('area'))
                            <span class="text-danger text-sm">{{ $errors->first('area') }}</span>
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
