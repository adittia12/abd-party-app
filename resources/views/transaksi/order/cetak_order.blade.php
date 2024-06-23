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
</head>

<body>
    <div class="main-content">
        <section class="section">
            <section class="section-header">
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-start">
                            <div class="p-2">
                                <small>
                                    Jl. KH. Ahmad Dahlan No.7 <br>
                                    Belakang Masjid Agung Karawang , Karawang , Indonesia <br>
                                    Telp 0267 - 401440 , HP <a href="https://wa.me/628562003009">08562003009</a> <br>
                                    e-mail <a
                                        href="mailto:abdulbasitabdkaum1@gmail.com">abdulbasitabdkaum1@gmail.com</a> <br>
                                    website <a href="https://www.abdrent.com">https://www.abdrent.com</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <p class="mt-3">Kepada : <b>{{ $cetakOrder->name_customer }}</b></p>
                        <input type="hidden" name="id" value="{{ $cetakOrder->id }}">
                        <div class="section-title mt-0">Order : <b>{{ $cetakOrder->order_number }}</b></div>
                        <small class="text-sm">Berikut kami kirimkan untuk pengajuan harga sewa pakai perlengkapan
                            sebagai
                            berikut :</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="small">
                                <tr>
                                    <th scope="col">Tanggal Pasang</th>
                                    <th scope="col">Mulai Acara</th>
                                    <th scope="col">Selesai</th>
                                    <th scope="col">Tanggal Order</th>
                                    <th scope="col">PIC</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($cetakOrder->date_pasang)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetakOrder->start_event)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetakOrder->end_event)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetakOrder->tgl_order)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-striped table-hover mt-2">
                        <thead class="small">
                            <tr>
                                <th>#</th>
                                <th>PRODUK</th>
                                <th>URAIAN</th>
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
                                        {{ $transaksi->description }}
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
                                if ($cetakOrder->discount_rate) {
                                    $diskon = $cetakOrder->discount_rate;
                                    $totalAkhir -= $diskon;
                                }
                                if ($cetakOrder->dp) {
                                    $dp = $cetakOrder->dp;
                                    $totalAkhir -= $dp;
                                }
                            @endphp
                            <tr>
                                <th colspan="5" class="text-right">Total Nominal</th>
                                <th>{{ 'Rp ' . number_format($totalNominal, 2, ',', '.') }}</th>
                            </tr>
                            @if ($diskon)
                                <tr>
                                    <th colspan="5" class="text-right">Diskon</th>
                                    <th>{{ 'Rp ' . number_format($diskon, 2, ',', '.') }}</th>
                                </tr>
                            @endif
                            @if ($dp)
                                <tr>
                                    <th colspan="5" class="text-right">Uang Muka (DP)</th>
                                    <th>{{ 'Rp ' . number_format($dp, 2, ',', '.') }}</th>
                                </tr>
                            @endif
                            <tr>
                                <th colspan="5" class="text-right">Total Akhir</th>
                                <th>{{ 'Rp ' . number_format($totalAkhir, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="d-flex flex-row mt-3">
                        <div class="p-2">
                            <div class="text-center small">
                                <p>
                                    Karawang, {{ \Carbon\Carbon::now()->format('d F Y') }} <br>
                                    <b>Hormat kami</b>
                                </p>
                                <br><br><br> <!-- Space for the actual signature -->
                                <p>(Abdul Basit)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
