<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DOC KARYAWAN - {{ $cetaEmployee->order_number }}</title>

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
                <div>
                    <div>
                        <p class="mt-3">Kepada : <b>{{ $cetaEmployee->name_customer }}</b> <br>
                            {{ $cetaEmployee->delivery_address }}
                        </p>
                        <input type="hidden" name="id" value="{{ Crypt::encrypt($cetaEmployee->id) }}">
                        <div class="section-title mt-0"><b>Surat Jalan</b></div>
                        <div class="section-title mt-0">Order : <b>{{ $cetaEmployee->order_number }}</b></div>
                        <small class="text-sm" style="font-size: 15px;"><b>Berikut kami kirimkan untuk pengajuan harga
                                sewa
                                pakai perlengkapan
                                sebagai
                                berikut :</b></small>
                    </div>
                    <br>
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
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->date_pasang)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->start_event)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->end_event)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->tgl_order)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-striped table-bordered table-hover mt-2">
                        <thead class="small">
                            <tr>
                                <th>#</th>
                                <th>PRODUK</th>
                                <th>URAIAN</th>
                                <th>JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach ($dataTransaksiCetak as $key => $transaksi)
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="justify-content-center">
                        <table class="table mt-3">
                            <tr class="mt-2">
                                <td>
                                    <div class="text-center">
                                        <p>
                                            <b>Pengirim</b>
                                        </p>
                                        <br>
                                        <p>____________________</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <p>
                                            <b>Penerima</b>
                                        </p>
                                        <br>
                                        <p>____________________</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
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
        <div class="page-break"></div>
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
                <div>
                    <div>
                        <p class="mt-3">Kepada : <b>{{ $cetaEmployee->name_customer }}</b> <br>
                            {{ $cetaEmployee->delivery_address }}
                        </p>
                        <div class="section-title mt-0"><b>Surat Kembali</b></div>
                        <div class="section-title mt-0">Order : <b>{{ $cetaEmployee->order_number }}</b></div>
                        <small class="text-sm" style="font-size: 15px;"><b>Berikut data barang yang harus dikirimkan
                                :</b></small>
                    </div>
                    <br>
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
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->date_pasang)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->start_event)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->end_event)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($cetaEmployee->tgl_order)->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ Auth::user()->name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-striped table-bordered table-hover mt-2">
                        <thead class="small">
                            <tr>
                                <th>#</th>
                                <th>PRODUK</th>
                                <th>URAIAN</th>
                                <th>JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            @foreach ($dataTransaksiCetak as $key => $transaksi)
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="justify-content-center">
                        <table class="table mt-3">
                            <tr class="mt-2">
                                <td>
                                    <div class="text-center">
                                        <p>
                                            <b>Pengirim</b>
                                        </p>
                                        <br>
                                        <p>____________________</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <p>
                                            <b>Penerima</b>
                                        </p>
                                        <br>
                                        <p>____________________</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
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
    </div>
</body>

</html>
