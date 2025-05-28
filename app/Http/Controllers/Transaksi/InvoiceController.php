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
    public function index(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $filterDate = $request->input('filterDate');
        $perPage = $request->input('per_page', 10);

        $invoice = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
            ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event')
            ->when($request->input('q'), function ($query, $q) {
                // Cek apakah q adalah tanggal yang valid
                $timestamp = strtotime($q);

                if ($timestamp) {
                    // Jika q adalah tanggal yang valid, format menjadi Y-m-d
                    $formattedQDate = date('Y-m-d', $timestamp);
                    $formattedQYearMonth = date('Y-m', $timestamp); // Tahun-Bulan

                    return $query->where('orders.name_customer', 'LIKE', '%' . $q . '%')
                        ->orWhere('invoices.invoice_number', 'LIKE', '%' . $q . '%')
                        ->orWhereDate('orders.start_event', $formattedQDate)
                        ->orWhere('orders.start_event', 'LIKE', '%' . $formattedQYearMonth . '%')
                        ->orWhere('orders.order_number', 'LIKE', '%' . $q . '%');
                } else {
                    // Jika q bukan tanggal yang valid, gunakan q apa adanya
                    return $query->where('orders.name_customer', 'LIKE', '%' . $q . '%')
                        ->orWhere('orders.start_event', 'LIKE', '%' . $q . '%')
                        ->orWhere('orders.order_number', 'LIKE', '%' . $q . '%')
                        ->orWhere('invoices.invoice_number', 'LIKE', '%' . $q . '%');
                }
            })
            ->when($filterMonth, function ($query, $filterMonth) {
                $filterMonth = date('Y-m', strtotime($filterMonth));
                return $query->where('invoices.period_date', 'LIKE', '%' . $filterMonth . '%');
            })
            ->when($filterDate, function ($query, $filterDate) {
                $filterDate = date('Y-m-d', strtotime($filterDate));
                return $query->whereDate('orders.start_event', $filterDate);
            })
            ->orderBy('invoices.created_at', 'DESC')
            ->paginate($perPage);

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
            ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event', 'orders.invoice_address', 'orders.discount_rate', 'orders.dp', 'orders.pajak_pph', 'orders.pajak_ppn', 'orders.pembayaran', 'orders.payment_type')
            ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
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

    public function docKonsumen($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID.');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $cetakonsumen = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
            ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event', 'orders.invoice_address', 'orders.discount_rate', 'orders.dp', 'orders.pajak_pph', 'orders.pajak_ppn', 'orders.delivery_address', 'orders.pembayaran', 'orders.payment_type')
            ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
            ->where('transactions.id_order', $cetakonsumen->id_order)
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('transaksi.invoice.doc.doc_konsumen', [
            'cetakonsumen' => $cetakonsumen,
            'dataTransaksiCetak' => $dataTransaksiCetak,
        ]);
        // Specify the file name
        $fileName = 'DOC-KONSUMEN-' . $cetakonsumen->name_customer . '-' . $cetakonsumen->invoice_number . '.pdf';

        // Stream PDF with specified file name
        return $pdf->stream($fileName);
    }

    public function docKantor($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID.');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $cetakKantor = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
            ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event', 'orders.invoice_address', 'orders.discount_rate', 'orders.dp', 'orders.pajak_pph', 'orders.pajak_ppn', 'orders.delivery_address', 'orders.no_phone', 'orders.pembayaran', 'orders.payment_type')
            ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
            ->where('transactions.id_order', $cetakKantor->id_order)
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('transaksi.invoice.doc.doc_kantor', [
            'cetakKantor' => $cetakKantor,
            'dataTransaksiCetak' => $dataTransaksiCetak,
        ]);
        // Specify the file name
        $fileName = 'DOC-KANTOR-' . $cetakKantor->name_customer . '-' . $cetakKantor->invoice_number . '.pdf';

        // Stream PDF with specified file name
        return $pdf->stream($fileName);
    }

    public function docEmployee($id)
    {
        try {
            $encId = decrypt($id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Alert::error('Error', 'Invalid ID.');
            return redirect()->back();
        }

        // Temukan order berdasarkan ID
        $cetaEmployee = Invoices::join('orders', 'invoices.id_order', '=', 'orders.id')
            ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event', 'orders.invoice_address', 'orders.delivery_address', 'orders.no_phone')
            ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksiCetak = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
            ->where('transactions.id_order', $cetaEmployee->id_order)
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('transaksi.invoice.doc.doc_karyawan', [
            'cetaEmployee' => $cetaEmployee,
            'dataTransaksiCetak' => $dataTransaksiCetak,
        ]);
        // Specify the file name
        $fileName = 'DOC-KARYAWAN-' . $cetaEmployee->name_customer . '-' . $cetaEmployee->invoice_number . '.pdf';

        // Stream PDF with specified file name
        return $pdf->stream($fileName);
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
            ->select('invoices.*', 'orders.order_number', 'orders.name_customer', 'orders.start_event', 'orders.tgl_order', 'orders.invoice_address', 'orders.delivery_address', 'orders.discount_rate', 'orders.dp', 'orders.pajak_pph', 'orders.pajak_ppn', 'orders.pembayaran', 'orders.payment_type')
            ->where('invoices.id', $encId)->first();

        // Mengambil transaksi terkait dengan order yang sesuai
        $dataTransaksi = Transactions::join('orders', 'transactions.id_order', '=', 'orders.id')
            ->join('products', 'transactions.id_product', '=', 'products.id')
            ->select('transactions.*', 'orders.order_number', 'products.name_product', 'products.inter_ref', 'products.unit_measure')
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

            Invoices::where(str_replace('/', '-', 'invoice_number'), $request->invoice_number)->update($update);
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
            Alert::success('Success', 'Data invoice berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data invoice gagal dihapus');
            return redirect()->back();
        }
    }
}
