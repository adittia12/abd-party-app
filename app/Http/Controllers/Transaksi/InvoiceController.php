<?php

namespace App\Http\Controllers\Transaksi;

use PDF;
use Alert;
use App\Models\Invoices;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
                            ->select('invoices.*', 'orders.order_number', 'orders.name_customer')
                            ->orderBy('invoices.created_at', 'DESC')->get();

        return view('transaksi.invoice.index', compact(['invoice']));
    }

    public function cetakInvoice($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID.');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $cetakInvoice = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
                                ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event')
                                ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref')
            ->where('transactions.id_order', $cetakInvoice->id_order)
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('transaksi.invoice.cetak_invoice', [
            'cetakInvoice' => $cetakInvoice,
            'dataTransaksiCetak' => $dataTransaksiCetak,
        ]);

        // Return PDF
        return $pdf->stream();
    }

    public function createPo(Request $request)
    {
        $validateData = $request->validate([
            'no_po_manual'      => 'required'
        ]);
        $invoiceId = $request->input('invoice_id');

        $invoice = Invoices::find($invoiceId);

        if ($invoice) {
            $invoice->update(['no_po_manual' => $validateData['no_po_manual']]);

            Alert::success('Success', 'No PO berhasil dibuat');
            return redirect()->back();
        } else {
            Alert::error('Error', 'No PO gagal dibuat, silakan coba kembali!');
        }
    }

    public function show($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID.');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $dataInvoice = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
                                ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event', 'orders.tgl_order', 'orders.invoice_address', 'orders.delivery_address', 'orders.discount_rate', 'orders.dp')
                                ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksi = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref')
            ->where('transactions.id_order', $dataInvoice->id_order)
            ->get();

        return view('transaksi.invoice.invoice_view', compact(['dataInvoice', 'dataTransaksi']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'no_po_manual'      => 'required'
        ]);

        DB::beginTransaction();
        try {
            $update = [
                'no_po_manual' => $validateData['no_po_manual']
            ];

            Invoices::where(str_replace('/', '-','invoice_number'), $request->invoice_number)->update($update);
            DB::commit();
            Alert::success('Success', 'Data berhasil diupdate');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data gagal diupdate');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoice)
    {
        DB::beginTransaction();
        try {
            $invoices = Invoices::where('id', $invoice)->first();
            $invoices->delete();
            DB::commit();
            Alert::success('Success', 'Data invoice ' . $invoice->invoice_number . ' berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data invoice ' . $invoice->invoice_number . ' gagal dihapus');
            return redirect()->back();
        }
    }
}
