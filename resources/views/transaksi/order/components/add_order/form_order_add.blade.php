<div class="row">
    <div class="col">
        <div class="form-group">
            <label>Company Type <span class="text-danger">* Wajib Diisi!!</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                <select name="company_type" id="company_type"
                    class="form-control @error('company_type') is-invalid @enderror">
                    <option value="">Select option</option>
                    <option value="Individual">Individual</option>
                    <option value="Company">Company</option>
                </select>
            </div>
            @if ($errors->has('company_type'))
                <span class="text-danger text-sm">{{ $errors->first('company_type') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Order Date <span class="text-danger">* Wajib Diisi!!</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <input type="date" name="tgl_order" id="tgl_order"
                    class="form-control datepicker @error('tgl_order') is-invalid @enderror"
                    value="{{ old('tgl_order') }}">
            </div>
            @if ($errors->has('tgl_order'))
                <span class="text-danger text-sm">{{ $errors->first('tgl_order') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Invoice Address <span class="text-danger">* Wajib Diisi!!</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <input type="text" name="invoice_address" id="invoice_address"
                    class="form-control @error('invoice_address') is-invalid @enderror"
                    value="{{ old('invoice_address') }}">
            </div>
            @if ($errors->has('invoice_address'))
                <span class="text-danger text-sm">{{ $errors->first('invoice_address') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Jumlah Hari</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="far fa-calendar-check"></i>
                    </div>
                </div>
                <input type="number" name="initial_terms" id="initial_terms" value="1" class="form-control"
                    value="{{ old('initial_terms') }}" placeholder="Ketik jumlah hari">
            </div>
        </div>
        <div class="row g-2">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="form-label">Tanggal Pasang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                        <input type="date" name="date_pasang" id="date_pasang" value="{{ old('date_pasang') }}"
                            class="form-control datepicker">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="form-label">Status Order <span class="text-danger">* Wajib Diisi!!</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                        <select name="status_order" id="status_order"
                            class="form-select form-control @error('status_order') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            <option value="Pengajuan">Pengajuan</option>
                            <option value="Sudah Ok">Sudah Ok</option>
                            <option value="Invoice">Invoice</option>
                            <option value="Lunas">Lunas</option>
                        </select>
                    </div>
                    @error('status_order')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Nama Customer <span class="text-danger">* Wajib Diisi!!</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <input type="text" name="name_customer" id="name_customer" value="{{ old('name_customer') }}"
                    class="form-control @error('name_customer') is-invalid @enderror">
            </div>
            @if ($errors->has('name_customer'))
                <span class="text-danger text-sm">{{ $errors->first('name_customer') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Number Phone</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <input type="number" name="no_phone" id="no_phone" value="{{ old('no_phone') }}"
                    placeholder="Ex : 628XXXXXXXX" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Deliver Address <span class="text-danger">* Wajib Diisi!!</span></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <input type="text" name="delivery_address" id="delivery_address"
                    value="{{ old('delivery_address') }}"
                    class="form-control @error('delivery_address') is-invalid @enderror">
            </div>
            @if ($errors->has('delivery_address'))
                <span class="text-danger text-sm">{{ $errors->first('delivery_address') }}</span>
            @endif
        </div>
        <div class="row g-2">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="form-label">Mulai Acara <span class="text-danger">* Wajib Diisi!!</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="date" name="start_event" id="start_event" value="{{ old('start_event') }}"
                            class="form-control @error('start_event') is-invalid @enderror">
                    </div>
                    @if ($errors->has('start_event'))
                        <span class="text-danger text-sm">{{ $errors->first('start_event') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="form-label">Acara Selesai <span class="text-danger">* Wajib Diisi!!</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="date" name="end_event" id="end_event" value="{{ old('end_event') }}"
                            class="form-control @error('end_event') is-invalid @enderror">
                    </div>
                    @if ($errors->has('end_event'))
                        <span class="text-danger text-sm">{{ $errors->first('end_event') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="form-label">Status Kirim <span class="text-danger">* Wajib Diisi!!</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-money-check"></i></span>
                        <select name="status_driver" id="status_driver"
                            class="form-control @error('status_driver') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            <option value="Dikirim" {{ old('status_driver') == 'Dikirim' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="Ambil Langsung"
                                {{ old('status_driver') == 'Ambil Langsung' ? 'selected' : '' }}>Ambil Langsung
                            </option>
                        </select>
                    </div>
                    @if ($errors->has('status_driver'))
                        <span class="text-danger text-sm">{{ $errors->first('status_driver') }}</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="form-label">Tanggal Pengambilan</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                        <input type="date" name="date_driver" id="date_driver" value="{{ old('date_driver') }}"
                            class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
