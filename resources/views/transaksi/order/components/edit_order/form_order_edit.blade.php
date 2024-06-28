<div class="row">
    <div class="col">
        <div class="form-group">
            <label>Company Type</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
                <select name="company_type" id="company_type"
                    class="form-control select2 @error('company_type') is-invalid @enderror">
                    <option value="{{ $order->company_type }}">{{ $order->company_type }}</option>
                    <option value="Individual">Individual</option>
                    <option value="Company">Company</option>
                </select>
            </div>
            @if ($errors->has('company_type'))
                <span class="text-danger text-sm">{{ $errors->first('company_type') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Order Date</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <input type="date" name="tgl_order" id="tgl_order"
                    class="form-control @error('tgl_order') is-invalid @enderror" value="{{ $order->tgl_order }}">
            </div>
            @if ($errors->has('tgl_order'))
                <span class="text-danger text-sm">{{ $errors->first('tgl_order') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label>Invoice Address</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <input type="text" name="invoice_address" id="invoice_address"
                    class="form-control @error('invoice_address') is-invalid @enderror"
                    value="{{ $order->invoice_address }}">
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
                    value="{{ $order->initial_terms }}" placeholder="Ketik jumlah hari">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Tanggal Pasang</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <input type="date" name="date_pasang" id="date_pasang" value="{{ $order->date_pasang }}"
                            class="form-control">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Status Order</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-check"></i>
                            </div>
                        </div>
                        <select name="status_order" id="status_order" class="form-control select2">
                            <option value="{{ $order->status_order }}">
                                {{ $order->status_order ?? 'Pilih status Order' }}
                            </option>
                            <option value="Pengajuan">Pengajuan</option>
                            <option value="Sudah Ok">Sudah Ok</option>
                            <option value="Invoice">Invoice</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Jenis Pajak</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-check"></i>
                            </div>
                        </div>
                        <select name="jenis_pajak" id="jenis_pajak" class="form-control select2">
                            <option value="{{ $order->jenis_pajak }}">{{ $order->jenis_pajak ?? 'Pilih Jenis Pajak' }}
                            </option>
                            <option value="PPH">PPH</option>
                            <option value="PPN">PPN</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Pajak</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <input type="number" name="pajak" id="pajak" value="{{ $order->pajak }}"
                            class="form-control" placeholder="Masukan nominal pajak">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Nama Customer</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
                <input type="text" name="name_customer" id="name_customer" value="{{ $order->name_customer }}"
                    class="form-control @error('name_customer') @enderror">
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
                <input type="number" name="no_phone" id="no_phone" value="{{ $order->no_phone }}"
                    placeholder="Ex : 628XXXXXXXX" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Deliver Address</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <input type="text" name="delivery_address" id="delivery_address"
                    value="{{ $order->delivery_address }}"
                    class="form-control @error('delivery_address') is-invalid @enderror">
            </div>
            @if ($errors->has('delivery_address'))
                <span class="text-danger text-sm">{{ $errors->first('delivery_address') }}</span>
            @endif
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Mulai Acara</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <input type="date" name="start_event" id="start_event" value="{{ $order->start_event }}"
                            class="form-control @error('start_event') is-invalid @enderror">
                    </div>
                    @if ($errors->has('start_event'))
                        <span class="text-danger text-sm">{{ $errors->first('start_event') }}</span>
                    @endif
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Acara Selesai</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <input type="date" name="end_event" id="end_event" value="{{ $order->end_event }}"
                            class="form-control @error('end_event') is-invalid @enderror">
                    </div>
                    @if ($errors->has('end_event'))
                        <span class="text-danger text-sm">{{ $errors->first('end_event') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Discount</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <input type="number" name="discount_rate" id="discount_rate" value="{{ $order->discount_rate }}"
                    class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label>Uang Muka (DP)</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <input type="number" name="dp" id="dp" value="{{ $order->dp }}"
                    class="form-control">
            </div>
        </div>
    </div>
</div>
