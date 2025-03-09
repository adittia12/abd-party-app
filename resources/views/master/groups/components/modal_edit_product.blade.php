<!-- Modal -->
<div class="modal fade" id="edit_group" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateGroupes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="code_id_group" id="e_code_id_group">
                    <div class="mb-3">
                        <label class="form-label" for="name_group">Nama Group</label>
                        <input type="text" class="form-control" id="e_name_group" name="name_group" value=""
                            placeholder="Nama Group">
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
