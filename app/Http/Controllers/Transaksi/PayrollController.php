<?php

namespace App\Http\Controllers\Transaksi;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\Employes;
use App\Models\PayrollPeriod;
use App\Models\TransactionOperational;
use App\Models\TransactionPayrolls;
use Auth;
use Carbon\Carbon;
use Crypt;
use DB;
use Illuminate\Http\Request;
use PDF;
use Session;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $searchQuery = $request->input('q');
        $perPage = $request->input('per_page', 10);

        $dataPayrollPeriod = PayrollPeriod::query();

        // ======== SEARCH ========
        if ($searchQuery) {
            $formatQYearMonth = null;

            // Cek format mmyyyy → ubah ke yyyy-mm
            if (preg_match('/^(0[1-9]|1[0-2])\d{4}$/', $searchQuery)) {
                $month = substr($searchQuery, 0, 2);
                $year = substr($searchQuery, 2, 4);
                $formatQYearMonth = "{$year}-{$month}";
            }
            // Cek format yyyy-mm
            elseif (preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $searchQuery)) {
                $formatQYearMonth = $searchQuery;
            }
            // Kalau format lain, coba parse pakai Carbon
            else {
                try {
                    $formatQYearMonth = Carbon::parse($searchQuery)->format('Y-m');
                } catch (\Exception $e) {
                    // Kalau gagal parse, treat sebagai teks biasa
                }
            }

            // Apply ke query
            $dataPayrollPeriod->where(function ($query) use ($searchQuery, $formatQYearMonth) {
                if ($formatQYearMonth) {
                    $query->where('month_period', 'like', $formatQYearMonth . '%');
                } else {
                    $query->where('month_period', 'like', '%' . $searchQuery . '%');
                }
            });
        }

        // ======== FILTER MONTH ========
        if ($filterMonth) {
            $formattedMonth = null;

            // Sama seperti search, handle mmyyyy dan yyyy-mm
            if (preg_match('/^(0[1-9]|1[0-2])\d{4}$/', $filterMonth)) {
                $month = substr($filterMonth, 0, 2);
                $year = substr($filterMonth, 2, 4);
                $formattedMonth = "{$year}-{$month}";
            } elseif (preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $filterMonth)) {
                $formattedMonth = $filterMonth;
            } else {
                try {
                    $formattedMonth = Carbon::parse($filterMonth)->format('Y-m');
                } catch (\Exception $e) {
                    // Abaikan kalau gagal
                }
            }

            if ($formattedMonth) {
                $dataPayrollPeriod->where('month_period', 'like', $formattedMonth . '%');
            }
        }

        $dataPayrollPeriod = $dataPayrollPeriod->latest()->paginate($perPage);

        return view('transaksi.payrolls.index', compact('dataPayrollPeriod'));
    }


    public function generatePayrollPeriod()
    {
        // Ambil periode terakhir
        $lastPeriod = PayrollPeriod::orderBy('month_period', 'desc')->first();

        if ($lastPeriod) {
            // Pastikan format sama
            $lastPeriodDate = Carbon::parse($lastPeriod->month_period)->startOfMonth();

            // Kalau sudah bulan ini, jangan generate lagi
            if ($lastPeriodDate->equalTo(Carbon::now()->startOfMonth())) {
                Alert::error('Error', 'Periode payroll bulan ini sudah ada!');
                return redirect()->back();
            }

            // Ambil bulan selanjutnya
            $nextPeriod = $lastPeriodDate->addMonth()->startOfMonth();
        } else {
            // Kalau belum ada data, mulai dari bulan sekarang
            $nextPeriod = Carbon::now()->startOfMonth();
        }

        // Simpan ke DB
        PayrollPeriod::create([
            'month_period' => $nextPeriod->format('Y-m-d')
        ]);

        Alert::success('Success', 'Periode payroll berhasil dibuat: ' . $nextPeriod->translatedFormat('F Y'));
        return redirect()->back();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($idPeriode)
    {
        $periode = PayrollPeriod::findOrFail(decrypt($idPeriode));

        // Ambil semua karyawan
        $employees = Employes::join('groupss', 'employess.id_group', '=', 'groupss.id')
            ->select('employess.name as name_employe', 'groupss.name_group', 'employess.id as id_employe_pay')
            ->get();

        return view('transaksi.payrolls.create_transaction_pay', [
            'periode' => $periode,
            'employees' => $employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idPeriodePayroll)
    {
        $periodePayroll = PayrollPeriod::findOrFail(decrypt($idPeriodePayroll));

        $request->validate([
            'id_employe.*' => 'required|exists:employess,id',
            'payroll.*' => 'required|numeric|min:0',
            'another_piece.*' => 'nullable|numeric|min:0',
            'desc_payroll.*' => 'nullable|string',
            'list_payroll.*' => 'required'
        ], [
            'id_employe.*.required' => 'Wajib pilih karyawan.',
            'id_employe.*.exists'   => 'Karyawan tidak ditemukan.',
            'payroll.*.required'    => 'Wajib isi gaji!',
            'payroll.*.numeric'     => 'Gaji harus berupa angka.',
            'payroll.*.min'         => 'Gaji tidak boleh negatif.',
            'list_payroll.*.required' => 'Wajib pilih jenis gaji!!!'
        ]);

        DB::beginTransaction();
        try {
            $monthPeriod = Carbon::parse($periodePayroll->month_period)->format('Y-m');

            foreach ($request['id_employe'] as $key => $id_employe) {
                $kasbon = DB::table('transaction_oprational')
                    ->join('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
                    ->where('transaction_oprational.id_employe', $id_employe)
                    ->where('list_bugeting.list_budget', 'Kasbon')
                    ->whereRaw("DATE_FORMAT(transaction_oprational.tgl_periode, '%Y-%m') = ?", [$monthPeriod])
                    ->select('transaction_oprational.id')
                    ->first();

                $existingInMasterEmploye = Employes::where('id', $id_employe)->exists();

                if (!$existingInMasterEmploye) {
                    DB::rollBack();
                    Alert::error('Error', 'Nama Karyawan tidak ada di master karyawan');
                    return redirect()->back();
                }

                // 🚨 Cek apakah kasbon untuk karyawan ini sudah pernah terinput di payroll periode ini
                $kasbonAlreadyInput = TransactionPayrolls::where('id_periode_pay', $periodePayroll->id)
                    ->where('id_employe', $id_employe)
                    ->whereNotNull('id_trans_operational_kasbon')
                    ->exists();

                TransactionPayrolls::create([
                    'id_periode_pay' => $periodePayroll->id,
                    'id_employe' => $id_employe,
                    // kalau sudah ada kasbon jangan simpan lagi
                    'id_trans_operational_kasbon' => (!$kasbonAlreadyInput && $kasbon) ? $kasbon->id : null,
                    'payroll' => $request['payroll'][$key],
                    'another_piece' => $request['another_piece'][$key] ?? 0,
                    'desc_payroll' => $request['desc_payroll'][$key] ?? null,
                    'list_payroll' => $request['list_payroll'][$key] ?? null
                ]);
            }

            DB::commit();
            Alert::success('Success', 'Data payroll berhasil ditambahkan');
            return redirect()->route('payrolls.show', Crypt::encrypt($periodePayroll->id));
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data Transaksi Gaji Gagal dibuat :(' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idsPayrollMonth)
    {
        $dataPayrollPeriod = PayrollPeriod::findOrFail(decrypt($idsPayrollMonth));

        $transPayroll = TransactionPayrolls::join('payroll_period', 'transaction_payrolls.id_periode_pay', '=', 'payroll_period.id')
            ->join('employess', 'transaction_payrolls.id_employe', '=', 'employess.id')
            ->join('groupss', 'employess.id_group', '=', 'groupss.id')
            ->select([
                'payroll_period.month_period',
                'employess.name as name_employe',
                'groupss.name_group',
                'transaction_payrolls.list_payroll',
                'transaction_payrolls.created_at',
                'transaction_payrolls.id as id_trans_pay',
                'transaction_payrolls.id_periode_pay',
            ])
            ->where('transaction_payrolls.id_periode_pay', $dataPayrollPeriod->id)
            ->get();

        return view('transaksi.payrolls.show_payroll_month', compact(['dataPayrollPeriod', 'transPayroll']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($periode, $idTransPay)
    {
        $dataEmployes = Employes::join('groupss', 'employess.id_group', '=', 'groupss.id')
            ->select(
                'employess.name as name_employe',
                'groupss.name_group',
                'employess.id as id_employe_pay'
            )
            ->get();

        $periodeFind = PayrollPeriod::findOrFail(decrypt($periode));

        $dataTransPayrolls = TransactionPayrolls::join('payroll_period', 'transaction_payrolls.id_periode_pay', '=', 'payroll_period.id')
            ->join('employess', 'transaction_payrolls.id_employe', '=', 'employess.id')
            ->join('groupss', 'employess.id_group', '=', 'groupss.id')
            ->leftJoin('transaction_oprational', 'transaction_payrolls.id_trans_operational_kasbon', '=', 'transaction_oprational.id')
            ->leftJoin('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
            ->select(
                'transaction_payrolls.id as id_trans_pay',
                'transaction_payrolls.id_employe',
                'transaction_payrolls.payroll',
                'transaction_payrolls.another_piece',
                'transaction_payrolls.desc_payroll',
                'transaction_payrolls.list_payroll',
                'payroll_period.month_period',
                'employess.name as name_employe',
                'groupss.name_group',
                DB::raw("CASE WHEN list_bugeting.list_budget = 'kasbon' THEN transaction_oprational.expend ELSE NULL END as expend_kasbon"),
                'list_bugeting.list_budget'
            )
            ->where('transaction_payrolls.id', '=', decrypt($idTransPay))
            ->where('transaction_payrolls.id_periode_pay', '=', decrypt($periode)) // filter by periode
            ->firstOrFail();

        return view('transaksi.payrolls.edit_transaction_pay', compact('dataEmployes', 'dataTransPayrolls', 'periodeFind'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $periode, $idTransPay)
    {
        $periodePayroll = PayrollPeriod::findOrFail(decrypt($periode));

        $request->validate([
            'payroll'        => 'required|numeric',
            'another_piece'  => 'nullable|numeric',
            'desc_payroll'   => 'nullable|string',
            'list_payroll'   => 'nullable|string',
        ]);

        try {
            $transPayroll = TransactionPayrolls::where('id', decrypt($idTransPay))
                ->where('id_periode_pay', $periodePayroll->id) // jangan decrypt 2x
                ->firstOrFail();

            $transPayroll->update([
                'id_employe'     => $request->id_employe,
                'payroll'        => $request->payroll,
                'another_piece'  => $request->another_piece ?? 0,
                'desc_payroll'   => $request->desc_payroll,
                'list_payroll'   => $request->list_payroll,
            ]);

            Alert::success('Success', 'Data gaji berhasil diperbarui.');
            return redirect()->back();
            // return redirect()->route('payrolls.show', Crypt::encrypt($periodePayroll->id));
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat update, silakan di cek kembali.');
            return redirect()->back();
        }
    }

    public function cetak_slip($periode, $idTransPay)
    {
        $periodeFind = PayrollPeriod::findOrFail(decrypt($periode));
        $dataTransPayrolls = TransactionPayrolls::query()
            ->join('payroll_period', 'transaction_payrolls.id_periode_pay', '=', 'payroll_period.id')
            ->join('employess', 'transaction_payrolls.id_employe', '=', 'employess.id')
            ->join('groupss', 'employess.id_group', '=', 'groupss.id')
            ->leftJoin('transaction_oprational', 'transaction_payrolls.id_trans_operational_kasbon', '=', 'transaction_oprational.id')
            ->leftJoin('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
            ->select([
                'transaction_payrolls.id as id_trans_pay',
                'transaction_payrolls.id_periode_pay',
                'transaction_payrolls.id_employe',
                'transaction_payrolls.payroll',
                'transaction_payrolls.another_piece',
                'transaction_payrolls.desc_payroll',
                'transaction_payrolls.list_payroll',
                'payroll_period.month_period',
                'employess.name as name_employe',
                'groupss.name_group',
                DB::raw("CASE WHEN list_bugeting.list_budget = 'kasbon' THEN transaction_oprational.expend ELSE NULL END as expend_kasbon"),
                'list_bugeting.list_budget',
            ])
            ->where('transaction_payrolls.id', decrypt($idTransPay))
            ->where('transaction_payrolls.id_periode_pay', decrypt($periode))
            ->firstOrFail();

        $formattedPeriod = Carbon::parse($periodeFind->month_period)->translatedFormat('F Y');

        $todayDate = Carbon::now('Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('l, d F Y H:i');

        $pdf = PDF::loadView('transaksi.payrolls.components.cetak_slip.cetak_slip', [
            'periodeFind' => $periodeFind,
            'dataTransPayrolls' => $dataTransPayrolls
        ]);
        return $pdf->stream('Slip-' . $dataTransPayrolls->name_employe . '-' . $formattedPeriod . '-' . $todayDate);
    }

    public function reportPayroll($periode)
    {
        $periodeFind = PayrollPeriod::findOrFail(decrypt($periode));
        $dataTransPayrolls = TransactionPayrolls::query()
            ->join('payroll_period', 'transaction_payrolls.id_periode_pay', '=', 'payroll_period.id')
            ->join('employess', 'transaction_payrolls.id_employe', '=', 'employess.id')
            ->join('groupss', 'employess.id_group', '=', 'groupss.id')
            ->leftJoin('transaction_oprational', 'transaction_payrolls.id_trans_operational_kasbon', '=', 'transaction_oprational.id')
            ->leftJoin('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
            ->select([
                'transaction_payrolls.id as id_trans_pay',
                'transaction_payrolls.id_periode_pay',
                'transaction_payrolls.id_employe',
                'transaction_payrolls.payroll',
                'transaction_payrolls.another_piece',
                'transaction_payrolls.desc_payroll',
                'transaction_payrolls.list_payroll',
                'payroll_period.month_period',
                'employess.name as name_employe',
                'groupss.name_group',
                DB::raw("CASE WHEN list_bugeting.list_budget = 'kasbon' THEN transaction_oprational.expend ELSE NULL END as expend_kasbon"),
                'list_bugeting.list_budget',
            ])
            ->where('payroll_period.id', decrypt($periode))
            ->get(); // <-- ambil banyak karyawan

        $formattedPeriod = Carbon::parse($periodeFind->month_period)->translatedFormat('F Y');

        $todayDate = Carbon::now('Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('l, d F Y H:i');

        $pdf = PDF::loadView('transaksi.payrolls.components.reports.report_payroll', [
            'periodeFind' => $periodeFind,
            'dataTransPayrolls' => $dataTransPayrolls
        ])->setPaper('a4', 'landscape'); // <-- ini yang bikin landscape

        return $pdf->stream('Report-Gaji-' . $formattedPeriod . '-' . str_replace([' ', ':'], '-', $todayDate) . '.pdf');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($payrollsId)
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

            $payrollPeriodDel = PayrollPeriod::where('id', decrypt($payrollsId))->first();
            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Hapus data Gaji bulan ' . $payrollPeriodDel->month_period,
                'date_time'     => $todayDate
            ];
            DB::table('user_activity_logs')->insert($activityLog);
            $payrollPeriodDel->delete();
            DB::commit();
            Alert::success('Success', 'Data Gaji bulan ' . $payrollPeriodDel->month_period . ' berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data gagal dihapus');
            return redirect()->back();
        }
    }

    public function destroyTransPay($IdPayTrans)
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
            $transPayrollDel = TransactionPayrolls::join('employess', 'transaction_payrolls.id_employe', '=', 'employess.id')
                ->join('payroll_period', 'transaction_payrolls.id_periode_pay', '=', 'payroll_period.id')
                ->select('employess.name as name_employe', 'transaction_payrolls.id', 'payroll_period.month_period', 'transaction_payrolls.list_payroll')
                ->where('transaction_payrolls.id', decrypt($IdPayTrans))->first();

            $formattedPeriod = Carbon::parse($transPayrollDel->month_period)->translatedFormat('F Y');

            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Hapus data Gaji ' . $transPayrollDel->name_employe . ' Periode ' . $formattedPeriod . ' dengan jenis gaji ' . $transPayrollDel->list_payroll,
                'date_time'     => $todayDate
            ];
            DB::table('user_activity_logs')->insert($activityLog);
            $transPayrollDel->delete();
            DB::commit();
            Alert::success('Success', 'Data Gaji ' . $transPayrollDel->name_employe . ' berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data gagal dihapus');
            return redirect()->back();
        }
    }
}
