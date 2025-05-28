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
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use PDF;

class OrderController extends Controller
{
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
        $orderData = $datasetOrder->orderBy('start_event', 'asc')->paginate($perPage);

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

        return view('transaksi.order.index', compact('orderData', 'filterMonth'));
    }

    public function billPayment(Request $request)
    {
        $request->validate([
            'pembayaran'    => 'required|numeric',
            'descript_payment'    => 'required',
            'status_driver' => 'required',
        ]);

        $paymentId = $request->input('order_pay_id');
        $payOrder = Orders::find($paymentId);

        $status = 'Lunas';

        if ($payOrder) {
            $payOrder->update([
                'pembayaran' => $request['pembayaran'],
                'descript_payment' => $request['descript_payment'],
                'status_driver' => $request['status_driver'],
                'date_driver' => $request['date_driver'],
                'status_order' => $status
            ]);

            Alert::success('Success', 'Kode order ' . $payOrder->order_number . ' sudah melunasi tagihan!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Kode order tidak ditemukan!');
        }
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
        $jenisTerm = 'Days';
        $tempat = 'Gudang Karawang';
        DB::beginTransaction();
        try {
            if ($request['status_order'] == 'Pilih Status') {
                $request['status_order'] = 'Pengajuan';
            }
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
                'warehouse' => $tempat,
                'price_list' => 'IDR',
                'discount_rate' => $request['discount_rate'],
                'pajak_pph' => $request['pajak_pph'],
                'pajak_ppn' => $request['pajak_ppn'],
                'descript_payment' => $request['descript_payment'],
                'dp' => $request['dp'],
                'status_order' => $request['status_order'],
                'pembayaran'   => $request['pembayaran'],
                'status_driver'   => $request['status_driver'],
                'date_driver'   => $request['date_driver'],
                'payment_type'   => $request['payment_type'],
            ]);

            if ($order && $order->status_order == 'Invoice' || $order->status_order == 'Lunas') {
                $periodeData = date('Y-m-d');
                Invoices::create([
                    'id_order' => $order->id,
                    'period_date' => $periodeData
                ]);
            }

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
            Alert::error('Error', 'Order gagal dibuat: ');
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
            // Tentukan status order berdasarkan jumlah pembayaran
            $statusOrder = $request->status_order; // Tetap menggunakan status saat ini jika tidak ada perubahan
            if ($request->pembayaran > 0) {
                $statusOrder = 'Lunas';
            }
            $order->update([
                'name_customer' => $request->name_customer,
                'tgl_order' => $request->tgl_order,
                'company_type' => $request->company_type,
                'no_phone' => $request->no_phone,
                'invoice_address' => $request->invoice_address,
                'delivery_address' => $request->delivery_address,
                'initial_terms' => $request->initial_terms,
                'start_event' => $request->start_event,
                'end_event' => $request->end_event,
                'date_pasang' => $request->date_pasang,
                'status_order' => $statusOrder,
                'pajak_pph' => $request->pajak_pph,
                'pajak_ppn' => $request->pajak_ppn,
                'payment_customer' => $request->payment_customer,
                'descript_payment' => $request->descript_payment,
                'price_list' => $request->price_list,
                'discount_rate' => $request->discount_rate,
                'dp' => $request->dp,
                'pembayaran' => $request->pembayaran,
                'status_driver' => $request->status_driver,
                'date_driver' => $request->date_driver,
                'payment_type' => $request->payment_type,
            ]);

            if ($order && $order->status_order == 'Invoice') {
                $periodeData = date('Y-m-d');
                Invoices::create([
                    'id_order' => $order->id,
                    'period_date' => $periodeData
                ]);
            }
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
            // Ensure $request->new_id_product is an array
            $new_id_product = $request->new_id_product ?? [];
            $newTransactionsCount = count($new_id_product);
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
            return redirect()->back();
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            Alert::error('Error', 'Order gagal diperbarui: ');
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

    public function approveSuratKembali(Request $request)
    {
        $orderId = $request->input('order_id_surat_kembali');
        $order = Orders::find($orderId);

        if ($order) {
            $order->update(['status_driver' => 'Surat Kembali']);
            Alert::success('Success', 'Surat Kembali Telah dibuat');
            return redirect()->back();
        } else {
            Alert::error('Failed', 'Surat Kembali gagal dibuat');
            return redirect()->back();
        }
    }

    public function suratJalan($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID :[');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $cetakOrder = Orders::findOrFail($encId);

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
            ->where('transactions.id_order', $cetakOrder->id)
            ->get();
        // Generate PDF
        $pdf = PDF::loadView('transaksi.order.letters.surat_jalan', ['cetakOrder' => $cetakOrder, 'dataTransaksiCetak' => $dataTransaksiCetak]);

        // Return PDF
        return $pdf->stream();
    }

    public function suratKembali($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID :[');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $cetakOrder = Orders::findOrFail($encId);

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
            ->where('transactions.id_order', $cetakOrder->id)
            ->get();
        // Generate PDF
        $pdf = PDF::loadView('transaksi.order.letters.surat_kembali', ['cetakOrder' => $cetakOrder, 'dataTransaksiCetak' => $dataTransaksiCetak]);

        // Return PDF
        return $pdf->stream();
    }


    public function cetak_order($id)
    {
        // Temukan order berdasarkan ID
        $cetakOrder = Orders::findOrFail($id);

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
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
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
            ->where('transactions.id_order', $cetakInvoice->id)
            ->get();

        // Mengambil invoice terkait dengan order yang sesuai
        $dataInvoice = Invoices::where('id_order', $cetakInvoice->id)->first();

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
        $user = Auth::user();
        Session::put('user', $user);

        try {

            $fullName = $user->name;
            $email = $user->email;
            $status = $user->status;
            $role_name = $user->role_name;

            $dt = Carbon::now('Asia/Jakarta');
            $todayDate = $dt->toDayDateTimeString();

            $orders = Orders::where('id', $order)->first();
            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Delete data order ' . $orders->order_number,
                'date_time'     => $todayDate
            ];
            DB::table('user_activity_logs')->insert($activityLog);
            $orders->delete();
            DB::commit();
            Alert::success('Success', 'Data order ' . $orders->order_number . ' berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data order gagal dihapus');
            return redirect()->back();
        }
    }
}
