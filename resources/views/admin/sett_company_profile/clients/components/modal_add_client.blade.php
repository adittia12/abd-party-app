<!-- Modal -->
<div class="modal fade" id="add_client" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="client_name">Nama Perusahaan</label>
                        <input type="text" class="form-control @error('client_name') is-invalid @enderror"
                            id="client_name" name="client_name" value="{{ old('client_name') }}"
                            placeholder="Nama Produk">
                        @if ($errors->has('client_name'))
                            <span class="text-danger text-sm">{{ $errors->first('client_name') }}</span>
                        @endif
                    </div>
                    <div class="section-title">File Image</div>
                    <div class="custom-file">
                        <input type="file"
                            class="form-control-file form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept=".jpg, .jpeg, .png">
                        @if ($errors->has('image'))
                            <span class="text-danger text-sm">{{ $errors->first('image') }}</span>
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
