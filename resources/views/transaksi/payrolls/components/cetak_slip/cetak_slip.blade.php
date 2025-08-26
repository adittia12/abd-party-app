<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $dataTransPayrolls->name_employe }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: "Arial", sans-serif;
            font-size: 14px;
            color: #333;
        }

        .slip-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.08);
        }

        .slip-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .slip-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: bold;
        }

        .slip-header small {
            color: #777;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-custom th,
        .table-custom td {
            border: 1px solid #ddd;
            padding: 8px 10px;
        }

        .table-custom thead {
            background: #009879;
            color: #fff;
        }

        .table-summary {
            margin-top: 20px;
        }

        .table-summary td {
            padding: 6px;
        }

        .net-pay {
            font-size: 16px;
            font-weight: bold;
            color: #009879;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature p {
            margin-bottom: 60px;
        }

        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            width: 300px;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: -1;
        }
    </style>
</head>

<body>
    {{-- Watermark --}}
    <div class="watermark">
        <img src="https://abd-ro.com/admin/assets/img/logo_abd.jpg" width="300px" alt="Watermark">
    </div>

    <div class="slip-container">
        <div class="slip-header">
            <h2>Slip Gaji Karyawan</h2>
            <small>Periode:
                {{ \Carbon\Carbon::parse($dataTransPayrolls->month_period)->translatedFormat('F Y') }}</small>
        </div>

        <table class="table-summary">
            <tr>
                <td><strong>Nama</strong></td>
                <td>: {{ $dataTransPayrolls->name_employe }}</td>
            </tr>
            <tr>
                <td><strong>Nama Group</strong></td>
                <td>: {{ $dataTransPayrolls->name_group }}</td>
            </tr>
            <tr>
                <td><strong>Jenis Gaji</strong></td>
                <td>: {{ $dataTransPayrolls->list_payroll }}</td>
            </tr>
        </table>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th class="text-right">Nominal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gaji</td>
                    <td class="text-right">{{ number_format($dataTransPayrolls->payroll, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Potongan Lain-lain</td>
                    <td class="text-right">{{ number_format($dataTransPayrolls->another_piece ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kasbon</td>
                    <td class="text-right">
                        {{ $dataTransPayrolls->expend_kasbon ? number_format($dataTransPayrolls->expend_kasbon, 0, ',', '.') : '-' }}
                    </td>
                </tr>
                @if ($dataTransPayrolls->desc_payroll)
                    <tr>
                        <td>Keterangan</td>
                        <td>{{ $dataTransPayrolls->desc_payroll }}</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                @php
                    $totalPotongan =
                        ($dataTransPayrolls->another_piece ?? 0) + ($dataTransPayrolls->expend_kasbon ?? 0);
                    $netPay = $dataTransPayrolls->payroll - $totalPotongan;
                @endphp
                <tr>
                    <th>Total Diterima</th>
                    <th class="text-right net-pay">{{ number_format($netPay, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="signature">
            <p>Karawang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p><strong>Abdul Basit</strong></p>
            <span>_______________________</span>
        </div>
    </div>
</body>

</html>
