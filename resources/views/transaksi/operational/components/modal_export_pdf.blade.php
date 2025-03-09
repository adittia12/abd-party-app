<!-- Modal -->
<div class="modal fade" id="report_operational" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Download Laporan Operasional</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('export.transOp') }}" method="GET" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tanggal Berdasarkan Tanggal Operasional</label>
                        <input type="date" class="form-control datepicker @error('filterDate') is-invalid @enderror"
                            id="filterDate" name="filterDate" aria-describedby="filterDate">
                        @error('filterDate')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Download</button>
                </div>
            </form>
        </div>
    </div>
</div>
