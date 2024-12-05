<div class="modal fade" id="edit_employe" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateEmployes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="e_hidden_code_employe" name="code_employe">

                    <div class="mb-3">
                        <label class="form-label" for="e_code_employe">Kode Karyawan</label>
                        <input type="text" class="form-control" id="e_code_employe" value="" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="id_group" class="form-label">Nama Group</label>
                        <select class="form-control" name="id_group" id="e_id_group" style="width: 100%">
                            <option value="">Pilih Group</option>
                            @foreach ($dataGroups as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name_group }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="e_name">Nama Karyawan</label>
                        <input type="text" class="form-control" id="e_name" name="name" value="">
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
