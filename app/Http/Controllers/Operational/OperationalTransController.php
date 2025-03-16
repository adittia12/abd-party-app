<?php

namespace App\Http\Controllers\Operational;

use App\Exports\Transaction\TransOperationalExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreOperTransRequest;
use App\Http\Requests\Master\UpdateOperTransRequest;
use App\Models\Employes;
use App\Models\Groupss;
use App\Models\ListBudgetModel;
use App\Models\OperationalMoney;
use App\Models\TransactionOperational;
use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class OperationalTransController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filterMonth = $request->input('filteringMonth');
        $filterDate = $request->input('filterDate');
        $searchQuery = $request->input('q');
        $sortBy = $request->input('sort_by', 'tgl_opartional'); // Default sort by tanggal
        $order = $request->input('order', 'desc'); // Default ascending

        // Pastikan hanya sorting berdasarkan 'tgl_opartional' atau 'budget'
        if (!in_array($sortBy, ['tgl_opartional', 'budget'])) {
            $sortBy = 'tgl_opartional';
        }
        $perPage = $request->input('per_page', 10); // Default 10 jika tidak ada input

        $dataOperational = OperationalMoney::query();

        // Pencarian berdasarkan kata kunci
        if ($searchQuery) {
            $timeStamp = strtotime($searchQuery);

            if ($timeStamp) {
                $formattedQDate = date('Y-m-d', $timeStamp);
                $formattedQYearMonth = date('Y-m', $timeStamp);

                $dataOperational->where(function ($query) use ($searchQuery, $formattedQDate, $formattedQYearMonth) {
                    $query->where('name_operational', 'like', '%' . $searchQuery . '%')
                        ->orWhere('jenis_pemasukan', 'like', '%' . $searchQuery . '%')
                        ->orWhere('tgl_opartional', 'like', '%' . $formattedQDate . '%')
                        ->orWhere('tgl_opartional', 'like', '%' . $formattedQYearMonth . '%');
                });
            } else {
                $dataOperational->where(function ($query) use ($searchQuery) {
                    $query->where('name_operational', 'like', '%' . $searchQuery . '%')
                        ->orWhere('jenis_pemasukan', 'like', '%' . $searchQuery . '%')
                        ->orWhere('tgl_opartional', 'like', '%' . $searchQuery . '%');
                });
            }
        }

        // Filter berdasarkan bulan
        if ($filterMonth) {
            $formattedMonth = Carbon::parse($filterMonth)->format('Y-m');
            $dataOperational->where('tgl_opartional', 'like', $formattedMonth . '%');
        }

        // Filter berdasarkan tanggal
        if ($filterDate) {
            $formattedDate = Carbon::parse($filterDate)->format('Y-m-d');
            $dataOperational->where('tgl_opartional', $formattedDate);
        }

        // Pagination dan sorting
        $dataOperational = $dataOperational->orderBy($sortBy, $order)->latest()->paginate($perPage);
        // Jika request datang dari AJAX, kembalikan hanya tabel
        if ($request->ajax()) {
            return view('transaksi.operational.partials.table_operational',  compact('dataOperational'))->render();
        }

        foreach ($dataOperational as $transOpera) {
            // Ambil semua transaksi terkait operasional uang
            $transOpera->moneyOperational = TransactionOperational::join('employess', 'transaction_oprational.id_employe', '=', 'employess.id')
                ->select('transaction_oprational.*', 'employess.name')
                ->where('transaction_oprational.id_operational', $transOpera->id)
                ->get();

            // Hitung total budget terpakai
            $totalBudgetUsed = $transOpera->moneyOperational->sum('expend');

            // Hitung sisa budget
            $remainingBudget = $transOpera->budget - $totalBudgetUsed;

            // Tambahkan ke objek $transOpera
            $transOpera->totalBudgetUsed = $totalBudgetUsed;
            $transOpera->remainingBudget = $remainingBudget;
        }


        return view('transaksi.operational.index', compact('dataOperational', 'filterMonth', 'filterDate'));
    }

    public function exportTransOp(Request $request)
    {
        $request->validate(['filterDate' => ['required']], ['filterDate' => ['required' => 'Pilih Tanggal Wajib Diisi!!!']]);

        try {
            $filterDate = $request->input('filterDate');
            $formattedDate = Carbon::parse($filterDate)->format('Y-m-d');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['msg' => 'Invalid Filter Date.']);
        }

        // Ambil data transaksi berdasarkan tanggal yang dipilih
        $reportOperational = TransactionOperational::join('operational_money', 'transaction_oprational.id_operational', '=', 'operational_money.id')
            ->leftJoin('employess', 'transaction_oprational.id_employe', '=', 'employess.id')
            ->leftJoin('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
            ->select([
                'transaction_oprational.expend',
                'transaction_oprational.tgl_periode',
                'operational_money.tgl_opartional',
                'operational_money.name_operational',
                'operational_money.budget',
                'operational_money.time_date',
                'employess.name as name_employee',
                'list_bugeting.list_budget'
            ])
            ->where('operational_money.tgl_opartional', $formattedDate)
            ->get();

        // **Tambahkan Pengecekan Jika Data Kosong**
        if ($reportOperational->isEmpty()) {
            Alert::info('INFO', 'Data laporan untuk tanggal ' . Carbon::parse($filterDate)->format('d F Y') . ' tidak tersedia.');
            return redirect()->back();
        }

        // Struktur untuk menyusun data ke dalam laporan
        $groupedData = [];
        $totalIn = 0;
        $totalOut = 0;

        foreach ($reportOperational as $data) {
            $descKey = $data->name_operational; // Nama budget
            $budgetAmount = $data->budget;
            $employeeName = $data->name_employee;
            $transactionType = $data->list_budget;
            $expendAmount = $data->expend;

            // Inisialisasi jika budget belum ada di array
            if (!isset($groupedData[$descKey])) {
                $groupedData[$descKey] = [
                    'budget' => $budgetAmount,
                    'transactions' => []
                ];
                $totalIn += $budgetAmount; // Total IN hanya dari budget
            }

            // Jika ada transaksi, tambahkan ke dalam daftar transaksi terkait budget
            if ($transactionType && $employeeName) {
                $transactionKey = $transactionType;

                if (!isset($groupedData[$descKey]['transactions'][$transactionKey])) {
                    $groupedData[$descKey]['transactions'][$transactionKey] = [
                        'employess' => [],
                        'total_expend' => 0
                    ];
                }

                // Tambahkan karyawan ke dalam transaksi terkait
                $groupedData[$descKey]['transactions'][$transactionKey]['employess'][] = $employeeName;
                $groupedData[$descKey]['transactions'][$transactionKey]['total_expend'] += $expendAmount;
                $totalOut += $expendAmount; // Total OUT dijumlahkan dari semua transaksi
            }
        }

        // Load tampilan PDF
        $pdf = PDF::loadView('transaksi.operational.exports.report_operational', [
            'groupedData' => $groupedData,
            'totalIn' => $totalIn,
            'totalOut' => $totalOut,
            'filterDate' => $filterDate
        ]);

        // Nama file PDF
        $dt = now('Asia/Jakarta');
        $todayDate = $dt->format('d_F_Y_His');
        return $pdf->stream('Laporan_Transaksi_Operasional_' . Carbon::parse($filterDate)->format('d_F_Y') . '_' . $todayDate . '.pdf');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listGroups = Groupss::all();
        $listEmploye = Employes::join('groupss', 'employess.id_group', '=', 'groupss.id')
                                ->select('groupss.name_group', 'employess.*')->get();
        $listBudget = ListBudgetModel::all();
        return view('transaksi.operational.add_operational', compact(['listGroups', 'listEmploye', 'listBudget']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOperTransRequest $request)
    {
        $timeZone = Carbon::now()->format('H:i:s');
        DB::beginTransaction();

        try {
            // Buat data operasional
            $operaMoney = OperationalMoney::create([
                'tgl_opartional' => $request->input('tgl_opartional'),
                'name_operational' => $request->input('name_operational'),
                'budget' => $request->input('budget'),
                'time_date' => $timeZone,
            ]);

            // Ambil input pengeluaran dan karyawan
            $expendInputs = $request->input('expend', []);
            $employeesInputs = $request->input('id_employe', []);
            $jenisPemasukanInputs = $request->input('jenis_pemasukan', []);
            $descriptions = $request->input('description', []);

            // Debugging untuk cek apakah data sudah benar
            // dd($employeesInputs); // Pastikan id_employe dikirim sebagai array

            if (empty($expendInputs) || empty($employeesInputs)) {
                DB::rollBack();
                Alert::error('Error', 'Pastikan semua input pengeluaran dan karyawan telah diisi.');
                return redirect()->back()->withInput();
            }

            foreach ($expendInputs as $key => $totalExpend) {
                // Pastikan setiap input `id_employe` berbentuk array
                $employees = isset($employeesInputs[$key]) ? (array) $employeesInputs[$key] : [];
                $jenisPemasukan = $jenisPemasukanInputs[$key] ?? null;
                $transDescrip = $descriptions[$key] ?? null;

                // Validasi keberadaan karyawan di database
                $existInMasterEmployes = Employes::whereIn('id', $employees)->pluck('id')->toArray();
                if (count($existInMasterEmployes) !== count($employees)) {
                    DB::rollBack();
                    Alert::error('Error', 'Salah satu atau lebih karyawan tidak terdaftar di database.');
                    return redirect()->back()->withInput();
                }

                // Tentukan jumlah pembagian
                $shareAmount = (count($employees) > 1) ? ($totalExpend / count($employees)) : $totalExpend;

                foreach ($employees as $employeeId) {
                    TransactionOperational::create([
                        'id_operational' => $operaMoney->id,
                        'id_employe' => $employeeId,
                        'expend' => $shareAmount,
                        'id_list_budget' => $jenisPemasukan,
                        'description' => $transDescrip,
                        'tgl_periode' => $operaMoney->tgl_opartional,
                    ]);
                }
            }

            DB::commit();
            Alert::success('Success', 'Data berhasil disimpan');
            return redirect()->route('operational.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan silakan coba kembali');
            return redirect()->back()->withInput();
        }
    }

    // public function generateBudget()
    // {
    //     $currentTime = Carbon::now()->format('H:i:s');
    //     $today = Carbon::now()->format('Y-m-d');

    //     // Ambil data operational terakhir yang masih memiliki sisa budget
    //     $latestOperational = OperationalMoney::whereDate('tgl_opartional', $today)
    //         ->orderBy('id', 'desc')
    //         ->first();

    //     if (!$latestOperational) {
    //         Alert::error('Error', 'Tidak ada data operational untuk hari ini.');
    //         return redirect()->back();
    //     }

    //     // Hitung total transaksi hari ini
    //     $totalExpenditures = TransactionOperational::where('id_operational', $latestOperational->id)
    //         ->sum('expend');

    //     $remainingBudget = $latestOperational->budget - $totalExpenditures;

    //     if ($remainingBudget > 0 && $currentTime >= '17:00:00') {
    //         // **Update budget lama agar sesuai dengan total pengeluaran**
    //         $latestOperational->update(['budget' => $totalExpenditures]);

    //         // **Buat entri baru untuk sisa budget**
    //         OperationalMoney::create([
    //             'tgl_opartional' => Carbon::parse($latestOperational->tgl_opartional)->addDay()->format('Y-m-d'),
    //             'name_operational' => 'Sisa budget pada tanggal ' . $latestOperational->tgl_opartional,
    //             'budget' => $remainingBudget,
    //             'time_date' => Carbon::now()->format('H:i:s'),
    //         ]);

    //         Alert::success('Success', 'Sisa budget berhasil dipindahkan ke hari berikutnya.');
    //     } else {
    //         Alert::info('Info', 'Tidak ada sisa budget atau belum melewati jam 17:00.');
    //     }

    //     return redirect()->back();
    // }

    public function generateBudget()
    {
        $currentTime = Carbon::now();

        // Cek apakah waktu sekarang masih sebelum jam 17:00
        $deadlineTime = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);

        if ($currentTime->lt($deadlineTime)) {
            Alert::info('Error', 'Generate budget hanya bisa dilakukan setelah jam 17:00.');
            return redirect()->back();
        }

        $tomorrow = Carbon::tomorrow()->format('Y-m-d'); // Selalu gunakan tanggal besok

        // Ambil semua data operational yang masih memiliki sisa budget
        $operationalWithRemainingBudget = OperationalMoney::whereRaw(
            'budget > (SELECT COALESCE(SUM(expend), 0) FROM transaction_oprational WHERE transaction_oprational.id_operational = operational_money.id)'
        )
        ->orderBy('tgl_opartional', 'asc') // Ambil dari tanggal terlama ke terbaru
        ->get();

        if ($operationalWithRemainingBudget->isEmpty()) {
            Alert::error('Error', 'Tidak ada sisa budget yang tersedia.');
            return redirect()->back();
        }

        $totalRemainingBudget = 0;

        foreach ($operationalWithRemainingBudget as $operational) {
            // Hitung total pengeluaran pada tanggal tersebut
            $totalExpenditures = TransactionOperational::where('id_operational', $operational->id)
                ->sum('expend');

            // Hitung sisa budget
            $remainingBudget = $operational->budget - $totalExpenditures;

            if ($remainingBudget > 0) {
                $totalRemainingBudget += $remainingBudget;

                // Update budget lama agar sesuai dengan total pengeluaran
                $operational->update(['budget' => $totalExpenditures]);
            }
        }

        if ($totalRemainingBudget > 0) {
            // Buat transaksi baru dengan sisa budget yang terkumpul untuk tanggal besok
            OperationalMoney::create([
                'tgl_opartional' => $tomorrow, // **Tanggal selalu besok dari hari ini**
                'name_operational' => 'Akumulasi Sisa Budget per ' . Carbon::now()->format('Y-m-d'),
                'budget' => $totalRemainingBudget,
                'time_date' => $currentTime->format('H:i:s'),
            ]);

            Alert::success('Success', 'Sisa budget berhasil dipindahkan ke tanggal ' . $tomorrow);
        } else {
            Alert::info('Info', 'Tidak ada sisa budget yang tersedia.');
        }

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show($operationalIds)
    {
        $operational = OperationalMoney::findOrFail(decrypt($operationalIds));
        $transOperational = TransactionOperational::join('operational_money', 'transaction_oprational.id_operational', '=', 'operational_money.id')
                                                ->join('employess', 'transaction_oprational.id_employe', '=', 'employess.id')
                                                ->join('groupss', 'employess.id_group', '=', 'groupss.id')
                                                ->join('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
                                                ->select([
                                                    'transaction_oprational.*',
                                                    'operational_money.tgl_opartional',
                                                    'operational_money.name_operational',
                                                    'employess.name as employee_name',
                                                    'groupss.name_group',
                                                    'list_bugeting.list_budget',
                                                    'list_bugeting.id as id_jen_pemasuk'])
                                                ->where('transaction_oprational.id_operational', $operational->id)
                                                ->get();


        return view('transaksi.operational.show_operational_finance', compact(['transOperational', 'operational']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operational = OperationalMoney::findOrFail($id);
        $listBudget = ListBudgetModel::all();
        $listEmploye = Employes::join('groupss', 'employess.id_group', '=', 'groupss.id')
                                ->select('groupss.name_group', 'employess.*')->get();

        $transOperational = TransactionOperational::join('operational_money', 'transaction_oprational.id_operational', '=', 'operational_money.id')
                                                ->join('employess', 'transaction_oprational.id_employe', '=', 'employess.id')
                                                ->join('groupss', 'employess.id_group', '=', 'groupss.id')
                                                ->join('list_bugeting', 'transaction_oprational.id_list_budget', '=', 'list_bugeting.id')
                                                ->select('transaction_oprational.*', 'operational_money.tgl_opartional', 'operational_money.name_operational', 'employess.name as employee_name', 'groupss.name_group', 'list_bugeting.list_budget', 'list_bugeting.id as id_jen_pemasuk')
                                                ->where('transaction_oprational.id_operational', $operational->id)
                                                ->get();

        return view('transaksi.operational.edit_operational', compact(['operational', 'listEmploye', 'transOperational', 'listBudget']));
    }

    public function deleteOperationalTrans($id)
    {
        try {
            $transaction = TransactionOperational::findOrFail($id);
            $transaction->delete();

            return response()->json(['success' => 'Transaction deleted successfully.']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Error deleting transaction.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOperTransRequest $request)
    {
        DB::beginTransaction();

        try {
            $operational = OperationalMoney::findOrFail($request->id_operational_trans);
            $operational->update([
                'name_operational' => $request->name_operational,
                'budget' => $request->budget
            ]);

            $updateTransactionIds = [];

            if (!empty($request->id_operational_transaksi)) {
                foreach ($request->id_operational_transaksi as $key => $id_operational_transaksi) {
                    if (isset($request->id_employe[$key]) && isset($request->id_list_budget[$key]) && isset($request->expend[$key])) {
                        $transaksi = TransactionOperational::findOrFail($id_operational_transaksi);
                        $transaksi->update([
                            'id_employe' => $request->id_employe[$key],
                            'id_list_budget' => $request->id_list_budget[$key],
                            'expend' => $request->expend[$key],
                        ]);
                    }
                }
            }


            // delete transaction that were not updated
            if (!empty($updateTransactionIds)) {
                TransactionOperational::where('id_operational', $operational->id)
                                    ->whereNotIn('id', $updateTransactionIds)
                                    ->delete();
            }

            // process new transaction
            $new_id_employe = $request->new_id_employe ?? [];
            $newTransactionCount = count($new_id_employe);
            if ($newTransactionCount > 0) {
                for ($i = 0; $i < $newTransactionCount; $i++) {
                    TransactionOperational::create([
                        'id_operational' => $operational->id,
                        'id_employe' => $new_id_employe[$i],
                        'id_list_budget' => $request->new_id_list_budget[$i],
                        'expend' => $request->new_expend[$i],
                        'description' => $request->new_description[$i],
                        'tgl_periode' => $operational->tgl_opartional
                    ]);
                }
            }

            DB::commit();
            Alert::success('Success', 'Transaksi Operasional berhasil diperbarui!!!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal update Transaksi Operasional!!! ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($operationaIds)
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

            $operationalMoneys = OperationalMoney::where('id', decrypt($operationaIds))->first();
            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Hapus data Operasional ' . $operationalMoneys->name_operational,
                'date_time'     => $todayDate
            ];
            DB::table('user_activity_logs')->insert($activityLog);
            $operationalMoneys->delete();
            DB::commit();
            Alert::success('Success', 'Data Operasional ' . $operationalMoneys->name_operational . ' berhasil dihapus!!!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Failed', 'Data operasional gagal dihapus');
            return redirect()->back();
        }
    }
}
