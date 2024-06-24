<?php

namespace App\Http\Controllers\Transaksi;

use App\Models\Orders;
use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Transasksi\OrderStoreRequest;
use App\Http\Requests\Transasksi\OrderUpdateRequest;
use App\Models\Invoices;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil nilai start_event terakhir
        // $lastDate = Orders::select('start_event')->orderBy('start_event', 'DESC')->first()?->start_event;

        // Mengecek apakah $lastDate ada
        $datasetOrder = Orders::select('order_number', 'name_customer', 'date_pasang', 'start_event', 'end_event', 'status_order', 'tgl_order', 'id')->orderBy('start_event', 'DESC')->get();
        return view('transaksi.order.index', compact(['datasetOrder']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataProduct = Products::all();
        return view('transaksi.order.add_order', compact(['dataProduct']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        $statusOrder = 'Pengajuan';
        $jenisTerm = 'Days';
        DB::beginTransaction();
        try {
            $order = Orders::create([
                'name_customer' => $request['name_customer'],
                'tgl_order' => $request['tgl_order'],
                'company_type' => $request['company_type'],
                'no_phone' => $request['no_phone'],
                'invoice_address' => $request['invoice_address'],
                'delivery_address' => $request['delivery_address'],
                'initial_terms' => $request['initial_terms'],
                'jenis_term' => $jenisTerm,
                'start_event' => $request['start_event'],
                'end_event' => $request['end_event'],
                'date_pasang' => $request['date_pasang'],
                'warehouse' => $request['warehouse'],
                'price_list' => 'IDR',
                'discount_rate' => $request['discount_rate'],
                'dp' => $request['dp'],
                'status_order' => $statusOrder,
            ]);

            foreach ($request['id_product'] as $key => $product) {
                $existInMasterProduct = Products::where('id', $product)->exists();

                if ($existInMasterProduct) {
                    Transactions::create([
                        'id_order' => $order->id,
                        'id_product' => $product,
                        'description' => $request['description'][$key],
                        'days' => $request['days'][$key],
                        'qty' => $request['qty'][$key],
                        'measure_list' => $request['measure_list'][$key],
                        'price' => $request['price'][$key],
                    ]);
                } else {
                    DB::rollBack();
                    Alert::error('Error', 'Product tidak ada di master product');
                    return redirect()->back();
                }
            }

            DB::commit();
            Alert::success('Success', 'Order berhasil dibuat');
            return redirect()->route('order.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Order gagal dibuat: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function autofillProduct(Request $request)
    {
        $product = $request->input('id_product');

        $transProd = Products::where('id', $product)->first();

        if ($transProd) {
            $data = [
                'sales_price'   => $transProd->sales_price,
                'unit_measure'  => $transProd->unit_measure
            ];

            return response()->json($data);
        } else {
            return response()->json(['Error' => 'Data not found'], 404);
        }
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
        return view('transaksi.order.detail_order', compact(['order', 'dataTransaksiDetail']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Orders::findOrFail($id);
        $dataProduct = Products::all();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksi = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
                                        ->join('products', 'transactions.id_product', '=', 'products.id')
                                        ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref')
                                        ->where('transactions.id_order', $order->id)
                                        ->get();
        // dd($dataTransaksi);
        // die;
        return view('transaksi.order.edit_order', compact(['order', 'dataProduct', 'dataTransaksi']));
    }

    public function deleteTransaction($id)
    {
        try {
            $transaction = Transactions::findOrFail($id);
            $transaction->delete();

            return response()->json(['success' => 'Transaction deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting transaction.'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(OrderUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            // Update data order
            $order = Orders::findOrFail($request->id_order_trans);
            $order->update([
                'name_customer' => $request->name_customer,
                'tgl_order' => $request->tgl_order,
                'company_type' => $request->company_type,
                'no_phone' => $request->no_phone,
                'invoice_address' => $request->invoice_address,
                'delivery_address' => $request->delivery_address,
                'initial_term' => $request->initial_term,
                'start_event' => $request->start_event,
                'end_event' => $request->end_event,
                'date_pasang' => $request->date_pasang,
                'warehouse' => $request->warehouse,
                'price_list' => $request->price_list,
                'discount_rate' => $request->discount_rate,
                'dp' => $request->dp,
            ]);

            // Initialize array to store IDs of updated transactions
            $updatedTransactionIds = [];

            // Process existing transactions (update or delete)
            if (!empty($request->id_transaksi)) {
                foreach ($request->id_transaksi as $key => $id_transaksi) {
                    $transaksi = Transactions::findOrFail($id_transaksi);
                    $transaksi->update([
                        'id_product' => $request->id_product[$key],
                        'description' => $request->description[$key],
                        'days' => $request->days[$key],
                        'qty' => $request->qty[$key],
                        'measure_list' => $request->measure_list[$key],
                        'price' => $request->price[$key],
                    ]);

                    // Add the updated transaction ID to the array
                    $updatedTransactionIds[] = $id_transaksi;
                }
            }

            // Delete transactions that were not updated (optional)
            if (!empty($updatedTransactionIds)) {
                Transactions::where('id_order', $order->id)
                    ->whereNotIn('id', $updatedTransactionIds)
                    ->delete();
            }

            // Process new transactions (create)
            $newTransactionsCount = count($request->new_id_product);
            if ($newTransactionsCount > 0) {
                for ($i = 0; $i < $newTransactionsCount; $i++) {
                    Transactions::create([
                        'id_order' => $order->id,
                        'id_product' => $request->new_id_product[$i],
                        'description' => $request->new_description[$i],
                        'days' => $request->new_days[$i],
                        'qty' => $request->new_qty[$i],
                        'measure_list' => $request->new_measure_list[$i],
                        'price' => $request->new_price[$i],
                    ]);
                }
            }

            // Commit transaction
            DB::commit();
            Alert::success('Success', 'Order berhasil diperbarui ' . $request->order_number);
            return redirect()->route('order.index');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            Alert::error('Error', 'Order gagal diperbarui: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function autofillProductOrder(Request $request)
    {
        $product = $request->input('new_id_product');

        $transProd = Products::where('id', $product)->first();

        if ($transProd) {
            $dataTrans = [
                'sales_price'   => $transProd->sales_price,
                'unit_measure'  => $transProd->unit_measure
            ];

            return response()->json($dataTrans);
        } else {
            return response()->json(['Error' => 'Data not found'], 404);
        }
    }

    public function approveOrder(Request $request)
    {
        $orderId = $request->input('order_id');

        $order = Orders::find($orderId);

        if ($order) {
            $order->update(['status_order' => 'Sudah Ok']);
            Alert::success('Success', 'Order sewa barang dengan kode ' . $order->order_number . ' sudah ok !!!');
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Order sewa ' . $order->order_number . ' gagal di approve');
            return redirect()->back();
        }
    }

    public function approveCancelOrder(Request $request)
    {
        $orderId = $request->input('order_id_cancel');

        $order = Orders::find($orderId);

        if ($order) {
            $order->update(['status_order' => 'Order Cancel']);
            Alert::success('Success', 'Order sewa di cancel berhasil ' . $order->order_number);
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Order sewa ' . $order->order_number . ' gagal dicancel');
            return redirect()->back();
        }
    }

    public function approveInvoice(Request $request)
    {
        $orderId = $request->input('order_id_invoice');

        $orderInvoice = Orders::find($orderId);
        $priodeData = date('Y-m-d');
        if ($orderInvoice) {
            $orderInvoice->update(['status_order' => 'Invoice']);
            Invoices::create([
                'id_order' => $orderId,
                'period_date' => $priodeData
            ]);
            Alert::success('Success', 'Invoice order sewa dengan kode ' . $orderInvoice->order_number . ' berhasil di approve');
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Invoice order sewa ' . $orderInvoice->order_number . ' gagal di approve');
            return redirect()->back();
        }
    }


    public function cetak_order($id)
    {
        // Temukan order berdasarkan ID
        $cetakOrder = Orders::findOrFail($id);

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
                                        ->join('products', 'transactions.id_product', '=', 'products.id')
                                        ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref')
                                        ->where('transactions.id_order', $cetakOrder->id)
                                        ->get();
        // Generate PDF
        $pdf = PDF::loadView('transaksi.order.cetak_order', ['cetakOrder' => $cetakOrder, 'dataTransaksiCetak' => $dataTransaksiCetak]);

        // Return PDF
        return $pdf->stream();
    }

    public function cetakInvoice($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->withErrors(['msg' => 'Invalid ID.']);
        }

        // Temukan order berdasarkan ID
        $cetakInvoice = Orders::findOrFail($encId);

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref')
            ->where('transactions.id_order', $cetakInvoice->id)
            ->get();

        // Mengambil invoice terkait dengan order yang sesuai
        $dataInvoice = Invoices::where('id_order', $cetakInvoice->id)->first();;

        // Generate PDF
        $pdf = PDF::loadView('transaksi.order.cetak_invoice', [
            'cetakInvoice' => $cetakInvoice,
            'dataTransaksiCetak' => $dataTransaksiCetak,
            'dataInvoice' => $dataInvoice
        ]);

        // Return PDF
        return $pdf->stream();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($order)
    {
        DB::beginTransaction();
        try {
            $orders = Orders::where('id', $order)->first();
            $orders->delete();
            DB::commit();
            Alert::success('Success', 'Data order ' . $orders->order_number . ' berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data order ' . $orders->order_number . ' gagal dihapus');
            return redirect()->back();
        }
    }
}
