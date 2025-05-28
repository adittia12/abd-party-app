<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Orders;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $filterDate = $request->input('filterDate');
        $perPage = $request->input('per_page', 10); // Default 10 jika tidak ada input

        $datasetOrder = Orders::when($request->input('q'), function ($query, $q) {
            $timestamp = strtotime($q);

            if ($timestamp) {
                $formattedQDate = date('Y-m-d', $timestamp);
                $formattedQYearMonth = date('Y-m', $timestamp); // Tahun-Bulan

                return $query->where('name_customer', 'LIKE', '%' . $q . '%')
                    ->orWhereDate('start_event', $formattedQDate)
                    ->orWhere('start_event', 'LIKE', '%' . $formattedQYearMonth . '%')
                    ->orWhere('order_number', 'LIKE', '%' . $q . '%');
            } else {
                return $query->where('name_customer', 'LIKE', '%' . $q . '%')
                    ->orWhere('start_event', 'LIKE', '%' . $q . '%')
                    ->orWhere('order_number', 'LIKE', '%' . $q . '%');
            }
        });

        if ($filterMonth) {
            $filterMonth = date('Y-m', strtotime($filterMonth));
            $datasetOrder->where('start_event', 'LIKE', '%' . $filterMonth . '%');
        }
        if ($filterDate) {
            $filterDate = date('Y-m-d', strtotime($filterDate));
            $datasetOrder->whereDate('start_event', $filterDate);
        }

        // Ambil data order yang dipaginate
        $orderData = $datasetOrder->where('status_order', '=', 'Lunas')->orderBy('start_event', 'asc')->paginate($perPage);

        // Ambil data transaksi terkait setiap order
        foreach ($orderData as $order) {
            $order->dataTagihan = Transactions::join('products', 'transactions.id_product', '=', 'products.id')
                ->select('transactions.*', 'products.name_product', 'products.inter_ref')
                ->where('transactions.id_order', $order->id)
                ->get();

            // Hitung total tagihan dan sisa tagihan
            $totalTagihan = $order->dataTagihan->sum(function ($item) {
                return $item->price * $item->qty;
            });

            $diskon = $order->discount_rate ?? 0;
            $dp = $order->dp ?? 0;
            $pajakPph = $order->pajak_pph ?? 0;
            $pajakPpn = $order->pajak_ppn ?? 0;
            $lunas = $order->pembayaran ?? 0;

            // Total akhir = total tagihan - diskon - dp + pajak
            $order->sisa_tagihan = $totalTagihan - $diskon - $dp - $lunas + $pajakPph + $pajakPpn;
        }

        return view('transaksi.order.components.reports.view_report_order',  compact('orderData', 'filterMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $encId = decrypt($id);
        $order = Orders::findOrFail($encId);

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiDetail = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref')
            ->where('transactions.id_order', $order->id)
            ->get();
        return view('transaksi.order.components.reports.view_report_order_detail', compact(['order', 'dataTransaksiDetail']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
