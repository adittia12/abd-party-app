<!-- Modal -->
<div class="modal fade" id="import-employe" tabindex="-1" aria-labelledby="importEmployeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="importEmployeLabel">Import Data Pegawai</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body Modal -->
            <form action="{{ route('import_employe') }}" id="importForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="importFile" class="form-label font-weight-bold">Pilih File untuk Import</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile" name="file"
                                accept=".xlsx, .xls, .csv" required>
                            <label class="custom-file-label" for="importFile">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted mt-2">
                            Format file yang didukung: .xlsx, .xls, .csv
                        </small>
                    </div>
                    <div class="text-right mt-3">
                        <a href="{{ url('/download-example-import-karyawan') }}" class="btn btn-link text-primary"
                            download>
                            <i class="fa fa-download"></i> Download Contoh Format Excel
                        </a>
                    </div>
                </div>
                <!-- Footer Modal -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Import
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
