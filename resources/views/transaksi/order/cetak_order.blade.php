<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Order</title>

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

        @page {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .page-break {
            page-break-before: always;
        }

        .small-row td {
            height: 10px;
        }

        .table-id {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 12px;
            font-family: Arial, sans-serif;
            min-width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .table-id thead tr {
            background-color: #00987a3d;
            color: #000000;
            text-align: left;
            font-weight: bold;
        }

        .table-id th,
        .table-id td {
            padding: 3px 7px;
            /* Mengurangi padding untuk mengurangi tinggi */
            border: 1px solid #ddd;
            text-align: left;
            height: 1px;
            /* Mengurangi height */
        }

        .table-id tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .table-id tbody tr:nth-of-type(even) {
            background-color: #f3f3f35c;
        }

        .table-id tbody tr:last-of-type {
            border-bottom: 2px solid #00987a69;
        }

        .table-id tfoot {
            background-color: #f3f3f36b;
            font-weight: bold;
        }

        .table-id tfoot .text-right {
            text-align: right;
        }

        .signature {
            margin-top: 20px;
            text-align: right;
            font-family: Arial, sans-serif;
            font-size: 1em;
        }

        .signature p {
            margin: 0;
            padding: 0;
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
                            <div class="p-1">
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
                <div>
                    <div>
                        <p style="font-size: 13px">Kepada : <b>{{ $cetakOrder->name_customer }}</b> <br>
                            {{ $cetakOrder->invoice_address }}
                        </p>
                        <input type="hidden" name="id" value="{{ $cetakOrder->id }}">
                        <div class="section-title">Order : <b>{{ $cetakOrder->order_number }}</b></div>
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
                                <td>
                                    {{ \Carbon\Carbon::parse($cetakOrder->date_pasang)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($cetakOrder->start_event)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($cetakOrder->end_event)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($cetakOrder->tgl_order)->translatedFormat('d F Y') }}
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
                                    <td style="height: 20px">
                                        {{ $transaksi->name_product }}
                                    </td>
                                    <td style="height: 20px">
                                        {{ $transaksi->description }}
                                    </td>
                                    <td style="height: 20px">
                                        {{ $transaksi->qty }} {{ $transaksi->measure_list }}
                                    </td>
                                    <td style="height: 20px">
                                        {{ $transaksi->price == 0 ? '0' : number_format($transaksi->price, 0, ',', '.') }}
                                    </td>
                                    <td style="height: 20px">
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

                                if ($cetakOrder->discount_rate) {
                                    $diskon = $cetakOrder->discount_rate;
                                    $totalAkhir -= $diskon;
                                }
                                if ($cetakOrder->dp) {
                                    $dp = $cetakOrder->dp;
                                    $totalAkhir -= $dp;
                                }

                                if ($cetakOrder->pajak) {
                                    $pajak = $cetakOrder->pajak;
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
                                    <th colspan="4" class="text-right">Pajak ({{ $cetakOrder->jenis_pajak }})</th>
                                    <th>{{ number_format($pajak, 0, ',', '.') }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th colspan="4" class="text-right">Total Akhir</th>
                                <th>{{ number_format($totalAkhir, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="signature">
                        <p><b>Hormat kami</b></p>
                        <br>
                        <p>(Abdul Basit)</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
