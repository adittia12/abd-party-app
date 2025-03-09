<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi Operasional</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            background-color: #f8f9fa;
            margin: 20px;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #343a40;
            text-transform: uppercase;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        p {
            text-align: center;
            font-size: 12px;
            color: #555;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #ffffff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
            font-size: 12px;
            /* Ukuran font sedang */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            /* Padding cukup agar rapi */
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
            text-transform: uppercase;
            font-size: 12px;
            /* Ukuran font header juga sedang */
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .signature-table {
            width: 100%;
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #555;
        }

        .signature-table td {
            padding: 40px 20px 10px;
            vertical-align: bottom;
            font-weight: bold;
            position: relative;
        }

        .signature-line {
            display: block;
            margin: 35px auto 5px;
            border-top: 2px solid black;
            width: 80%;
        }
    </style>
</head>

<body>

    <h2>Data Pengeluaran dan Pemasukkan ABD</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($filterDate)->format('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama/Deskripsi</th>
                <th>IN</th>
                <th>OUT</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($groupedData as $budgetName => $details)
                <tr class="bold">
                    <td>{{ $no++ }}</td>
                    <td>{{ $budgetName }}</td>
                    <td class="text-right">{{ number_format($details['budget'], 0, ',', '.') }}</td>
                    <td></td>
                </tr>

                @foreach ($details['transactions'] as $transactionName => $transactionDetails)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>&emsp; {{ $transactionName }} ({{ implode(', ', $transactionDetails['employess']) }})</td>
                        <td></td>
                        <td class="text-right">{{ number_format($transactionDetails['total_expend'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach

            <!-- Row untuk Total -->
            <tr class="bold" style="background-color: #007bff; color: white;">
                <td></td>
                <td>Total</td>
                <td class="text-right">{{ number_format($totalIn, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalOut, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Bagian Tanda Tangan -->
    <table class="signature-table">
        <tr>
            <td>Disetujui oleh:</td>
            <td>Mengetahui:</td>
            <td>Dibuat oleh:</td>
        </tr>
        <tr>
            <td>
                <div class="signature-line"></div>
                Abdul Basit
            </td>
            <td>
                <div class="signature-line"></div>
                Cressa Amelia
            </td>
            <td>
                <div class="signature-line"></div>
                {{ Auth::check() ? Auth::user()->name : 'Nama Tidak Tersedia' }}
            </td>
        </tr>
    </table>



</body>

</html>
