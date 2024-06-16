<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil nilai start_event terakhir
        $lastDate = Orders::select('start_event')->orderBy('start_event', 'DESC')->first();

        // Mengecek apakah $lastDate ada
        if ($lastDate) {
            $datasetOrder = Orders::select('order_number', 'name_customer', 'date_pasang', 'start_event', 'end_event', 'status_order', 'order_date')
                ->where('start_event', $lastDate->start_event)
                ->get();
        } else {
            // Penanganan jika tidak ada data ditemukan
            $datasetOrder = collect(); // Atau Anda bisa mengatur sesuai kebutuhan
        }
        return view('transaksi.order.index', compact(['datasetOrder']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transaksi.order.add_order');
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
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
