<!-- Modal -->
<div class="modal fade" id="delete_user" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-3" id="staticBackdropLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user/delete') }}" method="POST">
                    @csrf
                    <div class="justify-content-center">
                        <h1 class="badge badge-danger">Are you sure want to delete?.....</h1>
                    </div>
                    <input type="hidden" name="id" class="e_id" value="">
                    <input type="hidden" name="avatar" class="e_avatar" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </form>

        </div>
    </div>
</div>
