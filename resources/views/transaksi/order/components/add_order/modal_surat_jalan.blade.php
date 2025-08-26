<div class="modal fade" id="modalJalan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('order.updateSenderSuratJalan') }}">
            @csrf
            <input type="hidden" name="order_id" id="orderIdJalan">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Isi Data Pengirim (Surat Jalan)</h5>
                </div>
                <div class="modal-body">
                    <input name="sender_name" class="form-control mb-2" placeholder="Nama Pengirim" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan & Cetak</button>
                </div>
            </div>
        </form>
    </div>
</div>
