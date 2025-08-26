<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SURAT KEMBALI - ORDER {{ $cetakOrder->order_number }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    @include('transaksi.order.components.css.surat_jalan_css')
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
                            <div class="p-2">
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
                <div>
                    <div>
                        <p class="text-info-jalan">Kepada : <b>{{ $cetakOrder->name_customer }}</b> <br>
                            {{ $cetakOrder->delivery_address }}
                            @if ($cetakOrder->no_phone)
                                <br>Nomor HP : <b>0{{ $cetakOrder->no_phone }}</b>
                            @endif
                        </p>
                        <input type="hidden" name="id" value="{{ $cetakOrder->id }}">
                        <div class="section-title "><b class="text-info-jalan">Surat Kembali</b></div>
                        <div class="section-title text-info-jalan">Order : <b>{{ $cetakOrder->order_number }}</b></div>
                        @if ($cetakOrder->demolition_name)
                            <div class="section-title text-info-jalan">Nama Pembongkar :
                                <b>{{ $cetakOrder->demolition_name }}</b>
                            </div>
                        @endif
                        <small class="text-info-jalan"><b>Berikut kami kirimkan barang - barang tersebut dibawah sebagai
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
                                        {{ $transaksi->name_product }} - {{ $transaksi->description }}
                                    </td>
                                    <td>
                                        {{ $transaksi->description }}
                                    </td>
                                    <td>
                                        {{ $transaksi->qty }} {{ $transaksi->unit_measure }}
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
                                        <br>
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
                                        <br>
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
                                        <br>
                                        <br>
                                        <p>(Abdul Basit)</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="note-card">
                    <div class="note-card-title">Note:</div>
                    <div class="note-card-content">
                        <!-- Teks kosong untuk menambahkan note -->
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
