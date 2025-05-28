<div class="row g-2">
    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label class="form-label">Pajak PPH</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                <input type="number" name="pajak_pph" id="pajak_pph" value="{{ old('pajak_pph') }}" class="form-control"
                    placeholder="Masukan nominal pajak PPH">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label class="form-label">Pajak PPN</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                <input type="number" name="pajak_ppn" id="pajak_ppn" value="{{ old('pajak_ppn') }}"
                    class="form-control" placeholder="Masukan nominal pajak PPN">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label class="form-label">Discount</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                <input type="number" name="discount_rate" id="discount_rate" class="form-control"
                    value="{{ old('discount_rate') }}">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label class="form-label">Jenis Pembayaran <span class="text-danger">* Wajib
                    Diisi!!</span></label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                <select name="payment_type" id="payment_type"
                    class="form-select form-control @error('payment_type') is-invalid @enderror">
                    <option value="">Pilih Jenis Pembayaran</option>
                    <option value="Rekening Perusahaan"
                        {{ old('payment_type') == 'Rekening Perusahaan' ? 'selected' : '' }}>Rekening
                        Perusahaan
                    </option>
                    <option value="Rekening Pribadi" {{ old('payment_type') == 'Rekening Pribadi' ? 'selected' : '' }}>
                        Rekening Pribadi
                    </option>
                </select>
            </div>
            @error('payment_type')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label>Uang Muka (DP)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <input type="number" name="dp" id="dp" value="{{ old('dp') }}" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label>Bayar Lunas</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <input type="number" name="pembayaran" id="pembayaran" value="{{ old('pembayaran') }}"
                    class="form-control">
            </div>
        </div>
    </div>
    @php
        use Carbon\Carbon;
        $tanggalDefault = old('descript_payment') ? old('descript_payment') : Carbon::now()->translatedFormat('d F Y'); // Hasil: 28 Mei 2025
    @endphp

    <div class="col-md-6 col-lg-6">
        <div class="form-group">
            <label>Pembayaran Pelanggan</label>
            <p class="text-danger mb-2">Masukkan deskripsi pembayaran, contoh:<strong> Tf 28 Mei 2025 ke BCA Pak
                    Abdul.</strong></p>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-keyboard"></i>
                    </div>
                </div>
                <input type="text" name="descript_payment" id="descript_payment" value="{{ $tanggalDefault }}"
                    class="form-control">
            </div>
        </div>
    </div>
</div>
