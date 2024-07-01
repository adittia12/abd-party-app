<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Carbon\Carbon;
use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $filterYear = $request->input('filterYear', date('Y'));

        $countProduct = Products::whereNotNull('inter_ref');

        $sumTransactions = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->select(
                DB::raw('SUM(transactions.price) AS total_price'),
                DB::raw('MONTH(orders.start_event) AS month'),
                DB::raw('YEAR(orders.start_event) AS year')
            )
            ->where('orders.status_order', '=', 'Invoice');

        $countOrder = Orders::select(DB::raw('COUNT(status_order) AS total_status'), 'status_order')
            ->groupBy('status_order');

        $overviewOrder = Orders::select('order_number', 'start_event', 'status_order')->orderBy('created_at', 'DESC')->limit(5)->get();

        if ($filterMonth) {
            $filterMonth = date('Y-m', strtotime($filterMonth));
            $countProduct->where('created_at', 'LIKE', '%' . $filterMonth . '%');
            $countOrder->where('start_event', 'LIKE', '%' . $filterMonth . '%');
        }

        if ($filterYear) {
            $countProduct->whereYear('created_at', '=', $filterYear);
            $sumTransactions->whereYear('orders.start_event', '=', $filterYear);
            $countOrder->whereYear('start_event', '=', $filterYear);
        }

        $productCount = $countProduct->count();
        $transactionData = $sumTransactions->groupBy(DB::raw('MONTH(orders.start_event)'), DB::raw('YEAR(orders.start_event)'))
            ->orderBy(DB::raw('MONTH(orders.start_event)'))
            ->get();
        $orderStatus = $countOrder->get();

        // Menghitung total transaksi untuk tahun tersebut
        $totalYearlyTransaction = $transactionData->sum('total_price');

        // Memastikan data ada untuk 12 bulan
        $monthlyData = array_fill(1, 12, 0);
        foreach ($transactionData as $transaction) {
            $monthlyData[$transaction->month] = $transaction->total_price;
        }

        // Mengisi bulan yang kosong dengan total transaksi tahunan
        foreach ($monthlyData as $month => $totalPrice) {
            if ($totalPrice == 0) {
                $monthlyData[$month] = $totalYearlyTransaction;
            }
        }

        // Memformat data untuk Chart.js
        $dataTransaction = [
            'labels' => array_map(function($month) {
                return date('F', mktime(0, 0, 0, $month, 1));
            }, range(1, 12)),
            'datasets' => array_values($monthlyData)
        ];

        // Memformat data untuk grafik donat
        $donutOrder = [
            'labels' => $orderStatus->pluck('status_order')->toArray(),
            'datasets' => $orderStatus->pluck('total_status')->toArray()
        ];

        $dt = Carbon::now('Asia/Jakarta');
        $todayDate = $dt->toDayDateTimeString();

        return view('home.home', compact(
            'filterMonth', 'filterYear', 'todayDate', 'productCount',
            'dataTransaction', 'donutOrder', 'overviewOrder'
        ));
    }








}
