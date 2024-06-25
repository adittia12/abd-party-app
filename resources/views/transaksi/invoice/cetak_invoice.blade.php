<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice {{ $cetakInvoice ? $cetakInvoice->invoice_number : 'No Invoice Found' }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 250px;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            z-index: -1;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <!-- Watermark image -->
    <div class="watermark">
        <img src="{{ public_path('admin/assets/img/logo_abd.jpg') }}" width="300px" alt="Watermark">
    </div>
    <div class="main-content">
        <section class="section">
            <section class="section-header">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-start">
                            <div class="p-2">
                                <p style="font-size: 10px">
                                    <img src="{{ public_path('admin/assets/img/logo_abd.jpg') }}" width="250px"
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
                <div class="">
                    <div class="">
                        <table class="table">
                            <tr>
                                <td>{{ $cetakInvoice->name_customer }} <br> {{ $cetakInvoice->invoice_address }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <h5>KWITANSI</h5>
                                    <p class="small">
                                        <span class="text-secondary">Tanggal Kwitansi : </span> <br>
                                        {{ \Carbon\Carbon::parse($cetakInvoice->start_event)->translatedFormat('d F Y') }}
                                        <br>
                                        <span class="text-secondary">Kwitansi No. : </span> <br>
                                        {{ $cetakInvoice->invoice_number }} <br>
                                        @if ($cetakInvoice->no_po_manual)
                                            <span class="text-secondary">Nomor PO : </span> <br>
                                            {{ $cetakInvoice->no_po_manual }}
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="small">
                            <tr>
                                <th>#</th>
                                <th>PRODUK</th>
                                <th>JUMLAH</th>
                                <th>HARGA</th>
                                <th>SUB TOTAL</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @php
                                $totalNominal = 0;
                            @endphp
                            @foreach ($dataTransaksiCetak as $key => $transaksi)
                                @php
                                    $jumlahHarga = $transaksi->price * $transaksi->qty;
                                    $totalNominal += $jumlahHarga;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
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
                                        {{ $jumlahHarga == 0 ? '0' : 'Rp ' . number_format($jumlahHarga, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="small">
                            @php
                                $totalAkhir = $totalNominal;
                                $diskon = 0;
                                $dp = 0;
                                $pajak = 0;
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
                            @endphp
                            <tr>
                                <th colspan="4" class="text-right">Total Nominal</th>
                                <th>{{ 'Rp ' . number_format($totalNominal, 2, ',', '.') }}</th>
                            </tr>
                            @if ($diskon)
                                <tr>
                                    <th colspan="4" class="text-right">Diskon</th>
                                    <th>{{ 'Rp ' . number_format($diskon, 2, ',', '.') }}</th>
                                </tr>
                            @endif
                            @if ($dp)
                                <tr>
                                    <th colspan="4" class="text-right">Uang Muka (DP)</th>
                                    <th>{{ 'Rp ' . number_format($dp, 2, ',', '.') }}</th>
                                </tr>
                            @endif
                            @if ($pajak)
                                <tr>
                                    <th colspan="4" class="text-right">Pajak ({{ $cetakInvoice->jenis_pajak }})</th>
                                    <th>{{ 'Rp ' . number_format($pajak, 2, ',', '.') }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th colspan="4" class="text-right">Total Akhir</th>
                                <th>{{ 'Rp ' . number_format($totalAkhir, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="d-flex justify-content-center mt-3">
                        <table class="table table-hover">
                            <tr>
                                <td style="width: 350px" class="small">
                                    <div class="card-body" style="background: #e8e8e8">
                                        <p>
                                            <span class="text-secondary"><b>REKENING BANK</b></span> <br>
                                            BANK MANDIRI : 1730025222226 <br>
                                            Atas Nama : CV ABD KAUM 1 <br>
                                            NPWP : 436648703408000 <br>
                                            Atas Nama : CV.ABDUL BASIT (ABD KAUM 1)
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center small">
                                        <p>
                                            <b>Hormat kami</b>
                                        </p>
                                        <br><br>
                                        <p>(Abdul Basit)</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
