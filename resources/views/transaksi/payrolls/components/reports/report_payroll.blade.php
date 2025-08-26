<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Gaji Periode {{ \Carbon\Carbon::parse($periodeFind->month_period)->translatedFormat('F Y') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 13px;
            color: #333;
            background: #f9f9f9;
        }

        .report-container {
            max-width: 1000px;
            margin: auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #009879;
            padding-bottom: 15px;
        }

        .report-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #009879;
        }

        .report-header small {
            display: block;
            color: #666;
            margin-top: 5px;
        }

        .table-gaji {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-gaji th,
        .table-gaji td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12.5px;
            text-align: center;
        }

        .table-gaji thead {
            background: #009879;
            color: #fff;
        }

        .table-gaji tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        .net-pay {
            font-weight: bold;
            color: #009879;
        }

        .footer-signature {
            margin-top: 50px;
            text-align: right;
        }

        .footer-signature p {
            margin-bottom: 60px;
        }

        .watermark {
            position: fixed;
            top: 45%;
            left: 50%;
            width: 350px;
            transform: translate(-50%, -50%);
            opacity: 0.06;
            z-index: -1;
        }
    </style>
</head>

<body>
    {{-- Watermark --}}
    <div class="watermark">
        <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" width="350px" alt="Watermark">
    </div>

    <div class="report-container">
        {{-- HEADER --}}
        <div class="report-header">
            <h2>Laporan Gaji Karyawan</h2>
            <small>Periode: {{ \Carbon\Carbon::parse($periodeFind->month_period)->translatedFormat('F Y') }}</small>
        </div>

        <table class="table-gaji">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Group</th>
                    <th>Jenis Gaji</th>
                    <th>Gaji Pokok</th>
                    <th>Potongan Lain</th>
                    <th>Kasbon</th>
                    <th>Total Diterima</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataTransPayrolls as $row)
                    @php
                        $totalPotongan = ($row->another_piece ?? 0) + ($row->expend_kasbon ?? 0);
                        $netPay = $row->payroll - $totalPotongan;
                    @endphp
                    <tr>
                        <td>{{ $row->name_employe }}</td>
                        <td>{{ $row->name_group }}</td>
                        <td>{{ $row->list_payroll }}</td>
                        <td class="text-right">{{ number_format($row->payroll, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($row->another_piece ?? 0, 0, ',', '.') }}</td>
                        <td class="text-right">
                            {{ $row->expend_kasbon ? number_format($row->expend_kasbon, 0, ',', '.') : '-' }}
                        </td>
                        <td class="text-right net-pay">{{ number_format($netPay, 0, ',', '.') }}</td>
                        <td>{{ $row->desc_payroll ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                    $totalGaji = $dataTransPayrolls->sum('payroll');
                    $totalPotonganLain = $dataTransPayrolls->sum('another_piece');
                    $totalKasbon = $dataTransPayrolls->sum('expend_kasbon');
                    $totalSemuaPotongan = $totalPotonganLain + $totalKasbon;
                    $totalGajiBersih = $totalGaji - $totalSemuaPotongan;
                @endphp
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th class="text-right">{{ number_format($totalGaji, 0, ',', '.') }}</th>
                    <th class="text-right">{{ number_format($totalPotonganLain, 0, ',', '.') }}</th>
                    <th class="text-right">{{ number_format($totalKasbon, 0, ',', '.') }}</th>
                    <th class="text-right">{{ number_format($totalGajiBersih, 0, ',', '.') }}</th>
                    <th>-</th>
                </tr>
            </tfoot>

        </table>

        {{-- FOOTER --}}
        <div class="footer-signature">
            <p>Karawang, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
            <p><strong>Abdul Basit</strong></p>
            <span>_______________________</span>
        </div>
    </div>
</body>

</html>
