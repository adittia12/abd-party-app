<div class="modal fade" id="modalKembali" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('order.updateSenderSuratKembali') }}">
            @csrf
            <input type="hidden" name="order_id" id="orderIdKembali">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Isi Data Pengirim (Surat Kembali)</h5>
                </div>
                <div class="modal-body">
                    <input name="demolition_name" class="form-control" placeholder="Nama Pembongkaran" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan & Cetak</button>
                </div>
            </div>
        </form>
    </div>
</div>
