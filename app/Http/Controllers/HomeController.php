<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Http\Request;

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
        $filterYear = $request->input('filterYear');

        $countProduct = Products::whereNotNull('inter_ref');

        $sumTransactions = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
                            ->select(\DB::raw('SUM(transactions.price) AS total_price'), \DB::raw('MONTH(orders.start_event) AS month'), \DB::raw('YEAR(orders.start_event) AS year'))
                            ->where('orders.status_order', '=', 'Invoice');

        if ($filterMonth) {
            $filterMonth = date('Y-m', strtotime($filterMonth));
            $countProduct->where('created_at', 'LIKE', '%' . $filterMonth . '%');
        }

        if ($filterYear) {
            $countProduct->whereYear('created_at', '=', $filterYear );
            $sumTransactions->whereYear('orders.start_event', '=', $filterYear);
        }

        $productCount       = $countProduct->count();
        $transactionData    = $sumTransactions->groupBy(\DB::raw('MONTH(orders.start_event)'), \DB::raw('YEAR(orders.start_event)'))
        ->get();
        $labelsTransaction  = $sumTransactions->pluck('month')->toArray();
        $dataTransaction    = $sumTransactions->pluck('total_price')->toArray();

        return view('home.home', compact(['productCount', 'transactionData', 'labelsTransaction', 'dataTransaction']));
    }


}
