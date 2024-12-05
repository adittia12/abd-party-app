<!-- Modal -->
<div class="modal fade" id="add_group" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('group.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name_group">Nama Group</label>
                        <input type="text" class="form-control @error('name_group') is-invalid @enderror"
                            id="name_group" name="name_group" value="{{ old('name_group') }}" placeholder="Nama Group">
                        @if ($errors->has('name_group'))
                            <span class="text-danger text-sm">{{ $errors->first('name_group') }}</span>
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
