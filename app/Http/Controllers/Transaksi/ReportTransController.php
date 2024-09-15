<?php

namespace App\Http\Controllers\Transaksi;

use Carbon\Carbon;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Exports\order\orderExport;
use App\Exports\order\ReportOrderExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ReportTransController extends Controller
{
    public function export(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $dt = now('Asia/Jakarta');
        $todayDate = $dt->toDayDateTimeString();

        $datasetOrder = Orders::join('transactions', 'orders.id', '=', 'transactions.id_order')
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
                            ->where('orders.status_order', 'Invoice')
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
                            );

        if ($filterMonth) {
            $filterMonth = date('Y-m', strtotime($filterMonth));
            $filterData = $datasetOrder->where('start_event', 'LIKE', '%' . $filterMonth . '%')->get(); // Get the collection here

            if (!$filterData->isEmpty()) { // Check if the collection is empty
                $fileName = 'Laporan_Transaksi_' . str_replace('-', '_', Carbon::parse($filterMonth)->format('F Y')) . '_' . $todayDate . '.xlsx';
                return Excel::download(new orderExport($filterData), $fileName);
            } else {
                Alert::error('Wrong', 'Tidak ada data yang ditemukan untuk periode data yang dipilih : ' . $filterMonth);
                return redirect()->back();
            }
        } else {
            $fileName = 'Laporan_Transaksi_' . $todayDate . '.xlsx';
            return Excel::download(new orderExport(), $fileName);
        }
    }

    public function exportReportOrder(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $dt = now('Asia/Jakarta');
        $todayDate = $dt->toDayDateTimeString();

        $datasetOrder = Orders::join('transactions', 'orders.id', '=', 'transactions.id_order')
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
                            );

        if ($filterMonth) {
            $filterMonth = date('Y-m', strtotime($filterMonth));
            $filterData = $datasetOrder->where('start_event', 'LIKE', '%' . $filterMonth . '%')->get(); // Get the collection here

            if (!$filterData->isEmpty()) { // Check if the collection is empty
                $fileName = 'Laporan_Transaksi_' . str_replace('-', '_', Carbon::parse($filterMonth)->format('F Y')) . '_' . $todayDate . '.xlsx';
                return Excel::download(new ReportOrderExport($filterData), $fileName);
            } else {
                Alert::error('Wrong', 'Tidak ada data yang ditemukan untuk periode data yang dipilih : ' . $filterMonth);
                return redirect()->back();
            }
        } else {
            $fileName = 'Laporan_Transaksi_' . $todayDate . '.xlsx';
            return Excel::download(new ReportOrderExport(), $fileName);
        }
    }
}
