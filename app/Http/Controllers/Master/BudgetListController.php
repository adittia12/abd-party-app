<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ListBudgetModel;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class BudgetListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $opt_in = ListBudgetModel::when(request('q'), function($query){
            $search = request('q');
            return $query->where(function($q) use ($search){
                $q->where('list_budget', 'like', '%' . $search . '%');
            });
        })->latest()->paginate($perPage);

        return view('master.budget.index', compact(['opt_in']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['list_budget' => ['required', 'string']], ['list_budget' => ['required' => 'Jenis pemasukkan wajib diisi']]);

        DB::beginTransaction();
        try {
            $opt_in = new ListBudgetModel();
            $opt_in->list_budget = $request->list_budget;
            $opt_in->save();
            DB::commit();
            Alert::success('success', 'Data berhasil ditambah');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('error', 'Data gagal ditambah');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateOptIn(Request $request)
    {
        $request->validate(['list_budget' => ['required', 'string']], ['list_budget' => ['required' => 'Jenis pemasukkan wajib diisi']]);

        DB::beginTransaction();
        try {
            $update = [
                'list_budget' => $request->list_budget,
            ];
            ListBudgetModel::where('id', decrypt($request->id_opt_in))->update($update);
            DB::commit();
            Alert::success('success', 'Data berhasil diubah');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('error', 'Data gagal diubah' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($opt_in_id)
    {
        $user = Auth::user();
        Session::put('user', $user);
        $user = Session::get('user');
        DB::beginTransaction();

        try {
            $fullName       = $user->name;
            $email          = $user->email;
            $status         = $user->status;
            $role_name      = $user->role_name;

            $dt         = Carbon::now('Asia/Jakarta');
            $todayDate  = $dt->toDayDateTimeString();

            $opt_in = ListBudgetModel::where('id', decrypt($opt_in_id))->first();
            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Delete data jenis pengeluaran ' . $opt_in->list_budget,
                'date_time'     => $todayDate
            ];
            DB::table('user_activity_logs')->insert($activityLog);
            $opt_in->delete();
            DB::commit();
            Alert::success('success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('error', 'Data gagal dihapus');
            return redirect()->back();
        }
    }
}
