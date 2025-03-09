<!-- Modal -->
<div class="modal fade" id="add_employe" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                <form action="{{ route('employe.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <select class="form-control @error('id_group') is-invalid @enderror" name="id_group"
                            id="id_group" style="width: 100%">
                            <option value="">Pilih Group</option>
                            @foreach ($dataGroups as $item)
                                <option value="{{ $item->id }}">{{ $item->name_group }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_group'))
                            <span class="text-danger text-sm">{{ $errors->first('id_group') }}</span>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="name">Nama Karyawan</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Ketik Nama">
                        @if ($errors->has('name'))
                            <span class="text-danger text-sm">{{ $errors->first('name') }}</span>
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
