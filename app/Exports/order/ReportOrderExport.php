<?php

namespace App\Exports\order;

use App\Models\Orders;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportOrderExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithMapping, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function collection()
    {
        if ($this->data) {
            return $this->data;
        } else {
            return Orders::join('transactions', 'orders.id', '=', 'transactions.id_order')
                ->join('invoices', 'orders.id', '=', 'invoices.id_order')
                ->select(
                    'orders.order_number',
                    'orders.tgl_order',
                    'orders.name_customer',
                    'orders.start_event',
                    'orders.end_event',
                    'orders.discount_rate',
                    'orders.dp',
                    'orders.pajak',
                    'invoices.invoice_number',
                    \DB::raw('SUM(transactions.price) as total_nominal')
                )
                ->where('orders.status_order', 'Lunas')
                ->groupBy(
                    'orders.order_number',
                    'orders.tgl_order',
                    'orders.name_customer',
                    'orders.start_event',
                    'orders.end_event',
                    'orders.discount_rate',
                    'orders.dp',
                    'orders.pajak',
                    'invoices.invoice_number'
                )
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            ['Data Laporan ABD Bulanan'],
            [
                '#',
                'Kode Order',
                'Nama Pelanggan',
                'Tanggal Order',
                'Mulai Acara',
                'Selesai Acara',
                'Nomor Kwitansi',
                'Diskon',
                'Uang Muka',
                'Pajak',
                'Total Transaksi',
                'Total Nominal',
            ]
        ];
    }

    public function map($row): array
    {
        static $rowNumber = 3; // Starting from row 3 because row 2 is the header and first row of data starts from 3

        $mappedRow = [
            $rowNumber - 2, // Index starts from 1, whereas rowNumber starts from 3
            $row->order_number,
            $row->name_customer,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($row->tgl_order),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($row->start_event),
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($row->end_event),
            $row->invoice_number,
            $row->discount_rate ?: 0,
            $row->dp ?: 0,
            $row->pajak ?: 0,
            $row->total_nominal,
            "=K{$rowNumber} - H{$rowNumber} - I{$rowNumber} + J{$rowNumber}",
        ];

        $rowNumber++;
        return $mappedRow;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => ['argb' => 'FFA0A0A0'],
                'endColor' => ['argb' => 'FFFFFFFF'],
            ],
        ]);

        $sheet->getStyle('A2:L2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFCCCCCC'],
            ],
        ]);
    }

    public static function afterSheet($event)
    {
        $commaStyleFormat = '#,##0';

        // Apply date format
        $event->sheet->getDelegate()->getStyle('D3:F1000')
            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        // Apply comma style format
        $event->sheet->getDelegate()->getStyle('H3:H1000')
            ->getNumberFormat()->setFormatCode($commaStyleFormat);

        $event->sheet->getDelegate()->getStyle('I3:I1000')
            ->getNumberFormat()->setFormatCode($commaStyleFormat);

        $event->sheet->getDelegate()->getStyle('J3:J1000')
            ->getNumberFormat()->setFormatCode($commaStyleFormat);

        $event->sheet->getDelegate()->getStyle('K3:K1000')
            ->getNumberFormat()->setFormatCode($commaStyleFormat);

        $event->sheet->getDelegate()->getStyle('L3:L1000')
            ->getNumberFormat()->setFormatCode($commaStyleFormat);

        // Apply bold style to 'Total Nominal' column
        $event->sheet->getDelegate()->getStyle('L3:L1000')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        // Calculate the total for the last row
        $highestRow = $event->sheet->getDelegate()->getHighestRow();
        $totalCell = $highestRow + 1;
        $event->sheet->setCellValue("F{$totalCell}", 'Total');
        $event->sheet->setCellValue("K{$totalCell}", '=SUM(K3:K'.$highestRow.')');
        $event->sheet->setCellValue("L{$totalCell}", '=SUM(L3:L'.$highestRow.')');

        // Apply comma style format and bold style to the total cell
        $event->sheet->getDelegate()->getStyle("K{$totalCell}:L{$totalCell}")
            ->getNumberFormat()->setFormatCode($commaStyleFormat);
        $event->sheet->getDelegate()->getStyle("K{$totalCell}:L{$totalCell}")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => '#,##0',  // Diskon
            'I' => '#,##0',  // Uang Muka
            'J' => '#,##0',  // Pajak
            'K' => '#,##0',  // Total Transaksi
            'L' => '#,##0',  // Total Nominal
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [self::class, 'afterSheet'],
        ];
    }
}
