<!-- Modal -->
<div class="modal fade" id="edit_invoice" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invoice.update_invo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="invoice_number">No PO</label>
                            <fieldset disabled>
                                <input type="text" class="form-control" id="e_invoice_number" name="invoice_number"
                                    value="" placeholder="Invoice number">
                            </fieldset>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label" for="no_po_manual">No PO</label>
                            <input type="text" class="form-control" id="e_no_po_manual" name="no_po_manual"
                                value="" placeholder="Nama Produk">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="period_date">Periode data</label>
                        <fieldset disabled>
                            <input type="text" class="form-control" id="e_period_date" name="period_date"
                                value="" placeholder="Periode data">
                        </fieldset>
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
