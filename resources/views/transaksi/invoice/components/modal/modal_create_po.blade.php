<!-- Modal -->
<div class="modal fade" id="createPo" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create PO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice.create_po') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                        <label class="form-label" for="no_po_manual">Nomor PO</label>
                        <input type="text" class="form-control @error('no_po_manual') is-invalid @enderror"
                            id="no_po_manual" name="no_po_manual" value="{{ old('no_po_manual') }}"
                            placeholder="Role type">
                        @if ($errors->has('no_po_manual'))
                            <span class="text-danger text-sm">{{ $errors->first('no_po_manual') }}</span>
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
