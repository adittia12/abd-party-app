<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DOC KANTOR - {{ $cetakKantor->invoice_number }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    @include('transaksi.invoice.doc.style.doc_data_css')
</head>

<body>
    <!-- Watermark image -->
    <div class="watermark">
        <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" width="300px" alt="Watermark">
    </div>

    <section class="section">
        <section class="section-header">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-start">
                        <div class="p-2">
                            <p style="font-size: 10px">
                                <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" width="250px"
                                    alt="">
                                <br>
                                Jl. KH. Ahmad Dahlan No.7 <br>
                                Belakang Masjid Agung Karawang , Karawang , Indonesia <br>
                                Telp 0267 - 401440 , HP <a href="https://wa.me/628562003009">08562003009</a> <br>
                                e-mail <a href="mailto:abdulbasitabdkaum1@gmail.com">abdulbasitabdkaum1@gmail.com</a>
                                <br>
                                website <a href="https://www.abdrent.com">https://www.abdrent.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div>
                <div>
                    <p class="mt-3">Kepada : <b>{{ $cetakKantor->name_customer }}</b> <br>
                        {{ $cetakKantor->invoice_address }}
                    </p>
                    <input type="hidden" name="id" value="{{ Crypt::encrypt($cetakKantor->id_invoice) }}">
                    <div class="section-title mt-0">Order : <b>{{ $cetakKantor->order_number }}</b></div>
                    <small class="text-sm" style="font-size: 15px;"><b>Berikut kami kirimkan untuk pengajuan harga
                            sewa
                            pakai perlengkapan
                            sebagai
                            berikut :</b></small>
                </div>
                <br>
                <table class="table-id">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal Pasang</th>
                            <th scope="col">Mulai Acara</th>
                            <th scope="col">Selesai</th>
                            <th scope="col">Tanggal Order</th>
                            <th scope="col">PIC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->date_pasang)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->start_event)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->end_event)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->tgl_order)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-id">
                    <thead>
                        <tr>
                            <th>PRODUK</th>
                            <th>URAIAN</th>
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
                                    {{ $transaksi->name_product }}
                                </td>
                                <td>
                                    {{ $transaksi->description }}
                                </td>
                                <td>
                                    {{ $transaksi->qty }} {{ $transaksi->measure_list }}
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

                            if ($cetakKantor->discount_rate) {
                                $diskon = $cetakKantor->discount_rate;
                                $totalAkhir -= $diskon;
                            }
                            if ($cetakKantor->dp) {
                                $dp = $cetakKantor->dp;
                                $totalAkhir -= $dp;
                            }

                            if ($cetakKantor->pajak) {
                                $pajak = $cetakKantor->pajak;
                                $totalAkhir += $pajak;
                            }
                        @endphp
                        <tr>
                            <th colspan="4" class="text-right">Total Nominal</th>
                            <th>{{ number_format($totalNominal, 0, ',', '.') }}</th>
                        </tr>
                        @if ($diskon)
                            <tr>
                                <th colspan="4" class="text-right">Diskon</th>
                                <th>{{ number_format($diskon, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        @if ($dp)
                            <tr>
                                <th colspan="4" class="text-right">Uang Muka (DP)</th>
                                <th>{{ number_format($dp, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        @if ($pajak)
                            <tr>
                                <th colspan="4" class="text-right">Pajak ({{ $cetakKantor->jenis_pajak }})</th>
                                <th>{{ number_format($pajak, 0, ',', '.') }}</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="4" class="text-right">Total Akhir</th>
                            <th>{{ number_format($totalAkhir, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="signature-order">
                    <p><b>Hormat kami</b></p>
                    <br>
                    <p>(Abdul Basit)</p>
                </div>
            </div>
        </div>
    </section>

    <div class="page-break"></div>

    <section class="section">
        <section class="section-header-invoice">
            <div class="header-content-invoice">
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
                <p>{{ $cetakKantor->name_customer }}</p>
                <p>{{ $cetakKantor->invoice_address }}</p>
            </div>
            <div class="right">
                <h5>KWITANSI</h5>
                <p>
                    <span class="text-secondary">Tanggal Kwitansi: </span> <br>
                    {{ \Carbon\Carbon::parse($cetakKantor->start_event)->translatedFormat('d F Y') }} <br>
                    <span class="text-secondary">Kwitansi No.: </span> <br>
                    {{ $cetakKantor->invoice_number }} <br>
                    @if ($cetakKantor->no_po_manual)
                        <span class="text-secondary">Nomor PO : </span> <br>
                        {{ $cetakKantor->no_po_manual }}
                    @endif
                </p>
            </div>
        </div>
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
                            {{ $transaksi->name_product }}
                        </td>
                        <td>
                            {{ $transaksi->qty }} {{ $transaksi->measure_list }}
                        </td>
                        <td>
                            {{ $transaksi->price }}
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
                    if ($cetakKantor->discount_rate) {
                        $diskon = $cetakKantor->discount_rate;
                        $totalAkhir -= $diskon;
                    }
                    if ($cetakKantor->dp) {
                        $dp = $cetakKantor->dp;
                        $totalAkhir -= $dp;
                    }
                    if ($cetakKantor->pajak) {
                        $pajak = $cetakKantor->pajak;
                        $totalAkhir += $pajak;
                    }
                    if ($cetakKantor->pembayaran) {
                        $billPayment = $cetakKantor->pembayaran;
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
                        <th colspan="3" class="text-right">Pajak ({{ $cetakKantor->jenis_pajak }})</th>
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
                                <p><b>Hormat kami</b></p>
                                <br>
                                <p>(Abdul Basit)</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <div class="page-break"></div>
    <section class="section">
        <section class="section-header">
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-start">
                        <div class="p-1">
                            <p style="font-size: 10px">
                                <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" width="250px"
                                    alt="">
                                <br>
                                Jl. KH. Ahmad Dahlan No.7 <br>
                                Belakang Masjid Agung Karawang , Karawang , Indonesia <br>
                                Telp 0267 - 401440 , HP <a href="https://wa.me/628562003009">08562003009</a> <br>
                                e-mail <a href="mailto:abdulbasitabdkaum1@gmail.com">abdulbasitabdkaum1@gmail.com</a>
                                <br>
                                website <a href="https://www.abdrent.com">https://www.abdrent.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <div>
                <div>
                    <p class="text-info-jalan mt-2">Kepada : <b>{{ $cetakKantor->name_customer }}</b> <br>
                        {{ $cetakKantor->delivery_address }}
                        @if ($cetakKantor->no_phone)
                            <br>Nomor HP : <b>0{{ $cetakKantor->no_phone }}</b>
                        @endif
                    </p>
                    <div class="section-title mt-1">Order : <b
                            class="text-info-jalan">{{ $cetakKantor->order_number }}</b></div>
                    <small class="text-info-jalan"><b>Berikut kami kirimkan barang - barang tersebut dibawah sebagai
                            berikut :</b></small>
                </div>
                <table class="table-id">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal Pasang</th>
                            <th scope="col">Mulai Acara</th>
                            <th scope="col">Selesai</th>
                            <th scope="col">Tanggal Order</th>
                            <th scope="col">PIC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->date_pasang)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->start_event)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->end_event)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakKantor->tgl_order)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ Auth::user()->name }}</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-id">
                    <thead>
                        <tr>
                            <th>PRODUK</th>
                            <th>URAIAN</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataTransaksiCetak as $key => $transaksi)
                            <tr>
                                <td>
                                    {{ $transaksi->name_product }}
                                </td>
                                <td>
                                    {{ $transaksi->description }}
                                </td>
                                <td>
                                    {{ $transaksi->qty }} {{ $transaksi->measure_list }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="justify-content-center">
                    <table class="table mt-1">
                        <tr>
                            <td>
                                <div class="text-signature">
                                    <p>
                                        <b>Pengirim</b>
                                    </p>
                                    <br>
                                    <p>____________________</p>
                                </div>
                            </td>
                            <td>
                                <div class="text-signature">
                                    <p>
                                        <b>Penerima</b>
                                    </p>
                                    <br>
                                    <p>____________________</p>
                                </div>
                            </td>
                            <td>
                                <div class="text-signature">
                                    <p>
                                        <b>Hormat kami</b>
                                    </p>
                                    <br>
                                    <p>(Abdul Basit)</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
