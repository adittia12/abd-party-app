<?php

namespace App\Console\Commands;

use App\Models\OperationalMoney;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class AutoCreateOperationalMoney extends Command
{
    protected $signature = 'auto:create-operational-money';
    protected $description = 'Cek dan buat otomatis operational money jika masih ada sisa budget setelah jam 10:00';

    public function handle()
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        // Cek semua data operational money yang masih ada sisa budget hari ini
        $operationalMoney = OperationalMoney::where('tgl_opartional', $today)
            ->whereRaw('budget > (SELECT COALESCE(SUM(expend), 0) FROM transaction_operationals WHERE transaction_operationals.id_operational = operational_money.id)')
            ->get();

        foreach ($operationalMoney as $opera) {
            DB::beginTransaction();
            try {
                // Hitung total pengeluaran hari ini
                $totalExpend = DB::table('transaction_operationals')
                    ->where('id_operational', $opera->id)
                    ->sum('expend');

                // Hitung sisa budget
                $remainingBudget = $opera->budget - $totalExpend;

                if ($remainingBudget > 0) {
                    // Update budget lama agar sesuai dengan total pengeluaran
                    $opera->update(['budget' => $totalExpend]);

                    // Buat entry baru untuk sisa budget besok
                    OperationalMoney::create([
                        'tgl_opartional' => Carbon::parse($opera->tgl_opartional)->addDay()->format('Y-m-d'),
                        'name_operational' => 'Sisa budget pada tanggal ' . $opera->tgl_opartional,
                        'budget' => $remainingBudget,
                        'time_date' => Carbon::now()->format('H:i:s'),
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Gagal auto-create Operational Money: ' . $e->getMessage());
            }
        }

        $this->info('Auto-create Operational Money berhasil dijalankan.');
    }
}
