<!-- Modal -->
<div class="modal fade" id="edit_skill" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Kemampuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateSkillWork') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_skill" id="e_id_skill">
                    <div class="mb-3">
                        <label class="form-label" for="skill">Nama Kemampuan</label>
                        <input type="text" class="form-control @error('skill') is-invalid @enderror" id="e_skill"
                            name="skill" placeholder="Ketikan Skill">
                        @if ($errors->has('skill'))
                            <span class="text-danger text-sm">{{ $errors->first('skill') }}</span>
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
