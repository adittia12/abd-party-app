@extends('frontend.layout.master')
@section('title')
    Transaksi | Invoice detail
@endsection
@section('content')
    <section class="section">
        @include('sweetalert::alert')
        <div class="section-header">
            <h1>Invoice</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('invoice.index') }}">List Invoice</a></div>
                <div class="breadcrumb-item">Invoice</div>
                <input type="hidden" name="id" id="id" value="{{ Crypt::encrypt($dataInvoice->id) }}">
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">{{ $dataInvoice->invoice_number }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ $dataInvoice->name_customer }}<br>
                                        {{ $dataInvoice->delivery_address }}<br>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Shipped To:</strong><br>
                                        {{ $dataInvoice->name_customer }}<br>
                                        {{ $dataInvoice->invoice_address }} <br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Method:</strong><br>
                                        Mandiri : 1730025222226<br>
                                        <a href="abdulbasitabdkaum1@gmail.com">abdulbasitabdkaum1@gmail.com</a>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ \Carbon\Carbon::parse($dataInvoice->tgl_order)->translatedFormat('d F Y') }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Sub Total</th>
                                    </tr>
                                    <tr>
                                        @php
                                            $totalNominal = 0;
                                        @endphp
                                        @foreach ($dataTransaksi as $key => $transaksi)
                                            @php
                                                $jumlahHarga = $transaksi->price * $transaksi->qty;
                                                $totalNominal += $jumlahHarga;
                                            @endphp
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $transaksi->name_product }}
                                            </td>
                                            <td class="text-center">
                                                {{ $transaksi->qty }} {{ $transaksi->measure_list }}
                                            </td>
                                            <td class="text-right">
                                                {{ $transaksi->price == 0 ? '0' : 'Rp ' . number_format($transaksi->price, 2, ',', '.') }}
                                            </td>
                                            <td class="text-right">
                                                {{ $jumlahHarga == 0 ? '0' : 'Rp ' . number_format($jumlahHarga, 2, ',', '.') }}
                                            </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="section-title">Payment Method</div>
                                    <p class="section-lead">The payment method that we provide is to make it easier for you
                                        to pay invoices.</p>
                                    <div class="images">
                                        <img src="{{ asset('admin/assets/img/mandiri.png') }}" width="150px"
                                            alt="mandiri">
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    @php
                                        $totalAkhir = $totalNominal;
                                        $diskon = 0;
                                        $dp = 0;
                                        if ($dataInvoice->discount_rate) {
                                            $diskon = $dataInvoice->discount_rate;
                                            $totalAkhir -= $diskon;
                                        }
                                        if ($dataInvoice->dp) {
                                            $dp = $dataInvoice->dp;
                                            $totalAkhir -= $dp;
                                        }
                                    @endphp
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">
                                            {{ 'Rp ' . number_format($totalNominal, 2, ',', '.') }}</div>
                                    </div>
                                    @if ($diskon)
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Discount</div>
                                            <div class="invoice-detail-value">
                                                {{ 'Rp ' . number_format($diskon, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($dp)
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Uang Muka (DP)</div>
                                            <div class="invoice-detail-value">
                                                {{ 'Rp ' . number_format($dp, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                            {{ 'Rp ' . number_format($totalAkhir, 2, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <a href="{{ route('invoice.cetakInvoice', Crypt::encrypt($dataInvoice->id)) }}"
                        class="btn btn-warning btn-icon icon-left" target="_blank"><i class="fas fa-print"></i>Print</a>
                </div>
            </div>
        </div>
    </section>
@endsection
