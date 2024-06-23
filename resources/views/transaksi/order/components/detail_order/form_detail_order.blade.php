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
                <span class="form-control">{{ $order->company_type }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>Order Date</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <span
                    class="form-control">{{ \Carbon\Carbon::parse($order->tgl_order)->translatedFormat('d F Y') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>Invoice Address</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                </div>
                <span class="form-control">{{ $order->invoice_address }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>Jumlah Hari</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="far fa-calendar-check"></i>
                    </div>
                </div>
                <span class="form-control">{{ $order->initial_terms }} {{ $order->jenis_term }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>Tanggal Pasang</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                <span
                    class="form-control">{{ \Carbon\Carbon::parse($order->date_pasang)->translatedFormat('d F Y') }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>Warehouse</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                <span class="form-control">{{ $order->warehouse }}</span>
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
                <span class="form-control">{{ $order->name_customer }}</span>
            </div>
        </div>
        <div class="form-group">
            <label>Number Phone</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                </div>
                <span class="form-control"><a href="https://wa.me/{{ $order->no_phone }}"
                        target="_blank">{{ $order->no_phone }}</a></span>
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
                <span class="form-control">{{ $order->delivery_address }}</span>
            </div>
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
                        <span
                            class="form-control">{{ \Carbon\Carbon::parse($order->start_event)->translatedFormat('d F Y') }}</span>
                    </div>
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
                        <span
                            class="form-control">{{ \Carbon\Carbon::parse($order->end_event)->translatedFormat('d F Y') }}</span>
                    </div>
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
                <span
                    class="form-control">{{ $order->discount_rate == 0 ? '0' : 'Rp ' . number_format($order->discount_rate, 2, ',', '.') }}</span>
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
                <span
                    class="form-control">{{ $order->dp == 0 ? '0' : 'Rp ' . number_format($order->dp, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>
