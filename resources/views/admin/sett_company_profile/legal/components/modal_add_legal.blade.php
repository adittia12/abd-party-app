<!-- Modal -->
<div class="modal fade" id="add_legal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Legal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('legal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="title">Nama Document</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" placeholder="Nama Document" autofocus>
                        @if ($errors->has('title'))
                            <span class="text-danger text-sm">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="section-title">File Image</div>
                    <div class="custom-file">
                        <input type="file"
                            class="form-control-file form-control @error('document') is-invalid @enderror"
                            id="document" name="document" accept=".jpg, .jpeg, .png">
                        @if ($errors->has('document'))
                            <span class="text-danger text-sm">{{ $errors->first('document') }}</span>
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
