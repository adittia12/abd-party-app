<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice {{ $dataInvoice ? $dataInvoice->invoice_number : 'No Invoice Found' }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    @include('transaksi.order.components.css.orders_css_invoice')

</head>

<body>
    <!-- Watermark image -->
    <div class="watermark">
        <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" width="300px" alt="Watermark">
    </div>
    <div class="main-content">
        <section class="section">
            <section class="section-header">
                <div class="header-content">
                    <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" alt="Logo">
                    <p style="font-size: 10px">
                        Jl. KH. Ahmad Dahlan No.7 <br>
                        Belakang Masjid Agung Karawang, Karawang, Indonesia <br>
                        Telp 0267 - 401440, HP <a href="https://wa.me/628562003009">08562003009</a> <br>
                        e-mail <a href="mailto:abdulbasitabdkaum1@gmail.com">abdulbasitabdkaum1@gmail.com</a> <br>
                        website <a href="https://www.abdrent.com">https://www.abdrent.com</a>
                    </p>
                </div>
            </section>
            <div class="container-invoice">
                <div class="left">
                    <p>{{ $cetakInvoice->name_customer }}</p>
                    <p>{{ $cetakInvoice->invoice_address }}</p>
                </div>
                <div class="right">
                    <h5>KWITANSI</h5>
                    <p>
                        <span class="text-secondary">Tanggal Kwitansi: </span> <br>
                        {{ \Carbon\Carbon::parse($cetakInvoice->start_event)->translatedFormat('d F Y') }} <br>
                        <span class="text-secondary">Kwitansi No.: </span> <br>
                        {{ $dataInvoice->invoice_number }} <br>
                        @if ($dataInvoice->no_po_manual)
                            <span class="text-secondary">Nomor PO: </span> <br>
                            {{ $dataInvoice->no_po_manual }}
                        @endif
                    </p>
                </div>
            </div>
            <div>
                <table class="table-id">
                    <thead>
                        <tr>
                            <th>PRODUK</th>
                            <th>JUMLAH</th>
                            <th>HARGA</th>
                            <th>SUB TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalNominal = 0;
                        @endphp
                        @foreach ($dataTransaksiCetak as $key => $transaksi)
                            @php
                                $jumlahHarga = $transaksi->price * $transaksi->qty;
                                $totalNominal += $jumlahHarga;
                            @endphp
                            <tr>
                                <td>
                                    {{ $transaksi->name_product }} - {{ $transaksi->description }}
                                </td>
                                <td>
                                    {{ $transaksi->qty }} {{ $transaksi->unit_measure }}
                                </td>
                                <td>
                                    {{ $transaksi->price == 0 ? '0' : number_format($transaksi->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $jumlahHarga == 0 ? '0' : number_format($jumlahHarga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @php
                            $totalAkhir = $totalNominal;
                            $diskon = 0;
                            $dp = 0;
                            $pajak = 0;
                            $billPayment = 0;
                            if ($cetakInvoice->discount_rate) {
                                $diskon = $cetakInvoice->discount_rate;
                                $totalAkhir -= $diskon;
                            }
                            if ($cetakInvoice->dp) {
                                $dp = $cetakInvoice->dp;
                                $totalAkhir -= $dp;
                            }
                            if ($cetakInvoice->pajak) {
                                $pajak = $cetakInvoice->pajak;
                                $totalAkhir += $pajak;
                            }

                            if ($cetakInvoice->pembayaran) {
                                $billPayment = $cetakInvoice->pembayaran;
                                $totalAkhir -= $billPayment;
                            }
                        @endphp
                        <tr>
                            <th colspan="3" class="text-right">Total Nominal</th>
                            <th>{{ number_format($totalNominal, 0, ',', '.') }}</th>
                        </tr>
                        @if ($diskon)
                            <tr>
                                <th colspan="3" class="text-right">Diskon</th>
                                <th>{{ number_format($diskon, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        @if ($dp)
                            <tr>
                                <th colspan="3" class="text-right">Uang Muka (DP)</th>
                                <th>{{ number_format($dp, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        @if ($pajak)
                            <tr>
                                <th colspan="3" class="text-right">Pajak ({{ $cetakInvoice->jenis_pajak }})</th>
                                <th>{{ number_format($pajak, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        @if ($billPayment)
                            <tr>
                                <th colspan="3" class="text-right">Pelunasan</th>
                                <th>{{ number_format($billPayment, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3" class="text-right">Total Tagihan</th>
                            <th>{{ number_format($totalAkhir, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    <table class="table table-hover">
                        <tr>
                            <td style="width: 350px">
                                <div class="card-bank">
                                    <p class="send-info">
                                        <span class="text-secondary"><b>REKENING BANK</b></span> <br>
                                        BANK MANDIRI : 1730043222224 <br>
                                        Atas Nama : ABDUL BASIT KAUM I (ABD KAUM I) <br>
                                        NPWP : 436648703408000 <br>
                                        Atas Nama : CV.ABDUL BASIT (ABD KAUM 1)
                                    </p>
                                </div>
                            </td>
                            <td>
                                <div class="signature">
                                    <div class="signature-content">
                                        <p style="font-size: 15px"><b>Hormat kami</b></p>
                                        <br>
                                        <p style="font-size: 15px">(Abdul Basit)</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
