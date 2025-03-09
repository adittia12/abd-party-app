<?php

namespace App\Exports\Transaction;

use App\Models\TransactionOperational;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransOperationalExport implements FromView
{
    public function view(): View
    {
        $transactions = TransactionOperational::with([
            'operational_money',
            'employess.group',
            'list_budget'
        ])->orderBy('tgl_periode')->orderBy('id_operational')->get();

        $groupedTransactions = [];
        $totalIn = 0;
        $totalOut = 0;

        foreach ($transactions as $transaction) {
            $date = $transaction->tgl_periode;
            $time = optional($transaction->operational_money)->time_date;
            $desc = optional($transaction->operational_money)->name_operational . ' (' . optional($transaction->list_budget)->list_budget . ' - ' . optional($transaction->employess)->name . ')';
            $in = optional($transaction->operational_money)->budget ?? 0;
            $out = $transaction->expend;
            $status = $out > $in ? 'Kasbon' : '';

            $totalIn += $in;
            $totalOut += $out;

            $groupedTransactions[$date][$time][] = [
                'jam' => $time,
                'deskripsi' => $desc,
                'in' => $in,
                'out' => $out,
                'status' => $status
            ];
        }

        return view('transaksi.operational.exports.report_operational', [
            'groupedTransactions' => $groupedTransactions,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut
        ]);
    }
}
