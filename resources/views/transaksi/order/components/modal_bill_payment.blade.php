<!-- Modal -->
<div class="modal fade" id="billPayment" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Pembayaran Tagihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order.billPaymentOrder') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="order_pay_id" id="order_pay_id" value="">
                        <label class="form-label" for="pembayaran">Bayar Tagihan</label>
                        <input type="number" class="form-control @error('pembayaran') is-invalid @enderror"
                            id="pembayaran" name="pembayaran" value="{{ old('pembayaran') }}"
                            placeholder="Bill payment">
                        @if ($errors->has('pembayaran'))
                            <span class="text-danger text-sm">{{ $errors->first('pembayaran') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status_driver">Status Kirim</label>
                        <small class="form-text text-muted badeg">Pilih metode pengiriman, jika memilih <b>Ambil
                                langsung</b>
                            pastikan pelanggan melampirkan KTP</small>
                        <select name="status_driver" id="status_driver"
                            class="form-control @error('status_driver') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Ambil Langsung">Ambil Langsung</option>
                        </select>
                        @if ($errors->has('status_driver'))
                            <span class="text-danger text-sm">{{ $errors->first('status_driver') }}</span>
                        @endif
                    </div>

                    <div class="mb-3" id="date_driver_container" style="display: none;">
                        <label class="form-label" for="date_driver">Tanggal Pengambilan</label>
                        <input type="date" name="date_driver" id="date_driver" value="{{ old('date_driver') }}"
                            class="form-control">
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
