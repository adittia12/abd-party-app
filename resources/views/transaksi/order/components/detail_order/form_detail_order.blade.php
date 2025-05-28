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
                        <span
                            class="form-control">{{ \Carbon\Carbon::parse($order->date_pasang)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Status Order</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                        </div>
                        <span class="form-control">{{ $order->status_order }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Pajak PPH</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                        </div>
                        <span
                            class="form-control">{{ $order->pajak_pph == 0 ? '0' : 'Rp ' . number_format($order->pajak_pph, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Pajak PPN</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-check"></i>
                            </div>
                        </div>
                        <span
                            class="form-control">{{ $order->pajak_ppn == 0 ? '0' : 'Rp ' . number_format($order->pajak_ppn, 2, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if ($order->status_driver)
                    <div class="form-group">
                        <label>Status Kirim </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-money-check"></i>
                                </div>
                            </div>
                            <span class="form-control">{{ $order->status_driver }}</span>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <span class="form-control badge badge-danger">Tidak ada data</span>
                    </div>
                @endif
            </div>
            <div class="col">
                @if ($order->payment_type)
                    <div class="form-group">
                        <label>Jenis Pembayaran </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-money-check"></i>
                                </div>
                            </div>
                            <span class="form-control">{{ $order->payment_type }}</span>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <span class="form-control badge badge-danger">Tidak ada data</span>
                    </div>
                @endif
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
        <div class="row">
            <div class="col">
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
            </div>
            <div class="col">
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
        <div class="form-group">
            <label>Pembayaran Pelanggan</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-keyboard"></i>
                    </div>
                </div>
                <span class="form-control">{{ $order->descript_payment }}</span>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Bayar Lunas</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <span
                            class="form-control">{{ $order->pembayaran == 0 ? '0' : 'Rp ' . number_format($order->pembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @if ($order->pembayaran > 0)
                <div class="col">
                    <div class="form-group">
                        <label>Tanggal Lunas</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <span
                                class="form-control">{{ \Carbon\Carbon::parse($order->updated_at)->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @if ($order->status_driver == 'Dikirim')
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
        @elseif ($order->status_driver == 'Ambil Langsung')
            <div class="form-group">
                <label>Tanggal Pengambilan</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <span
                        class="form-control">{{ \Carbon\Carbon::parse($order->date_driver)->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        @else
            <div class="form-group">
                <span class="form-control badge badge-danger">Tidak ada data</span>
            </div>
        @endif
    </div>
</div>
