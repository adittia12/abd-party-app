<table class="table table-hover table-striped" id="table-1">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Descriptions</th>
            <th>Days</th>
            <th>Quantity</th>
            <th>Jenis Satuan</th>
            <th>Harga Satuan</th>
            <th>Jumlah Harga</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalNominal = 0;
        @endphp
        @foreach ($dataTransaksiDetail as $key => $transaksi)
            @php
                $jumlahHarga = $transaksi->price * $transaksi->qty;
                $totalNominal += $jumlahHarga;
            @endphp
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>
                    ({{ $transaksi->inter_ref }})
                    - {{ $transaksi->name_product }}
                </td>
                <td>
                    {{ $transaksi->description }}
                </td>
                <td>
                    {{ $transaksi->days }}
                </td>
                <td>
                    {{ $transaksi->qty }}
                </td>
                <td>
                    {{ $transaksi->measure_list }}
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
    <tfoot>
        @php
            $totalAkhir = $totalNominal;
            $diskon = 0;
            $dp = 0;
            $pajak = 0;
            if ($order->discount_rate) {
                $diskon = $order->discount_rate;
                $totalAkhir -= $diskon;
            }
            if ($order->dp) {
                $dp = $order->dp;
                $totalAkhir -= $dp;
            }
            if ($order->pajak) {
                $pajak = $order->pajak;
                $totalAkhir += $pajak;
            }
        @endphp
        <tr>
            <th colspan="7" class="text-right">Total Nominal</th>
            <th>{{ 'Rp ' . number_format($totalNominal, 2, ',', '.') }}</th>
        </tr>
        @if ($diskon)
            <tr>
                <th colspan="7" class="text-right">Diskon</th>
                <th>{{ 'Rp ' . number_format($diskon, 2, ',', '.') }}</th>
            </tr>
        @endif
        @if ($dp)
            <tr>
                <th colspan="7" class="text-right">Uang Muka (DP)</th>
                <th>{{ 'Rp ' . number_format($dp, 2, ',', '.') }}</th>
            </tr>
        @endif
        @if ($pajak)
            <tr>
                <th colspan="7" class="text-right">Pajak ({{ $order->jenis_pajak }})</th>
                <th>{{ 'Rp ' . number_format($pajak, 2, ',', '.') }}</th>
            </tr>
        @endif
        <tr>
            <th colspan="7" class="text-right">Total Akhir</th>
            <th>{{ 'Rp ' . number_format($totalAkhir, 2, ',', '.') }}</th>
        </tr>
    </tfoot>
</table>
