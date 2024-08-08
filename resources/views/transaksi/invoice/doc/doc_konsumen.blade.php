<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DOC KONSUMEN - {{ $cetakonsumen->invoice_number }}</title>

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

    <div class="main-content">
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
                                    e-mail <a
                                        href="mailto:abdulbasitabdkaum1@gmail.com">abdulbasitabdkaum1@gmail.com</a> <br>
                                    website <a href="https://www.abdrent.com">https://www.abdrent.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="mt-3">
                    <p style="font-size: 13px">Kepada : <b>{{ $cetakonsumen->name_customer }}</b> <br>
                        {{ $cetakonsumen->invoice_address }}
                    </p>
                    <input type="hidden" name="id" value="{{ Crypt::encrypt($cetakonsumen->id_invoice) }}">
                    <div class="section-title mt-2">Order : <b>{{ $cetakonsumen->order_number }}</b></div>
                    <small style="font-size: 13px;"><b>Berikut kami kirimkan untuk pengajuan harga
                            sewa
                            pakai perlengkapan
                            sebagai
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
                            <td>{{ \Carbon\Carbon::parse($cetakonsumen->date_pasang)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakonsumen->start_event)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakonsumen->end_event)->translatedFormat('d F Y') }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cetakonsumen->tgl_order)->translatedFormat('d F Y') }}
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

                            if ($cetakonsumen->discount_rate) {
                                $diskon = $cetakonsumen->discount_rate;
                                $totalAkhir -= $diskon;
                            }
                            if ($cetakonsumen->dp) {
                                $dp = $cetakonsumen->dp;
                                $totalAkhir -= $dp;
                            }

                            if ($cetakonsumen->pajak) {
                                $pajak = $cetakonsumen->pajak;
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
                                <th colspan="4" class="text-right">Pajak ({{ $cetakonsumen->jenis_pajak }})</th>
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
                    <p>{{ $cetakonsumen->name_customer }}</p>
                    <p>{{ $cetakonsumen->invoice_address }}</p>
                </div>
                <div class="right">
                    <h5>KWITANSI</h5>
                    <p>
                        <span class="text-secondary">Tanggal Kwitansi: </span> <br>
                        {{ \Carbon\Carbon::parse($cetakonsumen->start_event)->translatedFormat('d F Y') }} <br>
                        <span class="text-secondary">Kwitansi No.: </span> <br>
                        {{ $cetakonsumen->invoice_number }} <br>
                        @if ($cetakonsumen->no_po_manual)
                            <span class="text-secondary">Nomor PO : </span> <br>
                            {{ $cetakonsumen->no_po_manual }}
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
                        if ($cetakonsumen->discount_rate) {
                            $diskon = $cetakonsumen->discount_rate;
                            $totalAkhir -= $diskon;
                        }
                        if ($cetakonsumen->dp) {
                            $dp = $cetakonsumen->dp;
                            $totalAkhir -= $dp;
                        }
                        if ($cetakonsumen->pajak) {
                            $pajak = $cetakonsumen->pajak;
                            $totalAkhir += $pajak;
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
                            <th colspan="3" class="text-right">Pajak ({{ $cetakonsumen->jenis_pajak }})
                            </th>
                            <th>{{ number_format($pajak, 0, ',', '.') }}</th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="text-right">Total Akhir</th>
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
                                    BANK MANDIRI : 1730025222226 <br>
                                    Atas Nama : CV ABD KAUM 1 <br>
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
    </div>
</body>

</html>
