<?php

namespace App\Http\Controllers\Master;

use App\Imports\EmployeImport;
use App\Models\Groupss;
use App\Models\Employes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\RequestStoreEmploye;
use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class EmployesController extends Controller
{
    public function importEmploye(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new EmployeImport, $request->file('file'));
            Alert::success('Berhasil', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('employe.index');
    }


    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $dataEmploye = Employes::join('groupss', 'employess.id_group', '=', 'groupss.id')
                                ->select('groupss.name_group', 'employess.code_employe', 'employess.name')
                                ->when(request('q'), function($query) {
                                    $search = request('q');
                                    return $query->where(function($q) use ($search) {
                                        $q->where('groupss.name_group', 'like', '%' . $search . '%')
                                            ->orWhere('employess.name', 'like', '%' . $search . '%')
                                            ->orWhere('employess.code_employe', 'like', '%' . $search . '%');
                                    });
                                })->latest('employess.created_at')->paginate($perPage);

        $dataGroups = Groupss::all();


        return view('master.employe.index', compact(['dataEmploye', 'dataGroups']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestStoreEmploye $request)
    {
        DB::beginTransaction();
        try {
            $employe = new Employes();
            $employe->id_group = $request->id_group;
            $employe->name = $request->name;
            $employe->save();
            DB::commit();
            Alert::success('Success', 'Data berhasil ditambah');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data gagal ditambah');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateEmploye(Request $request)
    {
        DB::beginTransaction();
        try {
            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $update = [
                'id_group' => $request->id_group,
                'name' => $request->name,
            ];

            $activityLog = [
                'user_name'   => Auth::user()->name,
                'email'       => Auth::user()->email,
                'status'      => Auth::user()->status,
                'role_name'   => Auth::user()->role_name,
                'modify_user' => 'Ubah data karyawan ' . $request->code_employe,
                'date_time'   => $todayDate,
            ];

            // Pengecekan apakah data di variabel $update dan $activityLog lengkap
            $isUpdateDataComplete = !in_array(null, $update) && !in_array('', $update);
            $isActivityLogComplete = !in_array(null, $activityLog) && !in_array('', $activityLog);

            if ($isUpdateDataComplete && $isActivityLogComplete) {
                DB::table('user_activity_logs')->insert($activityLog);
                Employes::where('code_employe', $request->code_employe)->update($update);
                DB::commit();
                Alert::success('Success', 'Data berhasil diubah');
                return redirect()->back();
            } else {
                DB::rollBack();
                Alert::error('Error', 'Data gagal diubah');
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data ' . $request->name . ' gagal diubah');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($employe)
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

            $employess = Employes::where('code_employe', decrypt($employe))->first();

            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Delete data karyawan ' . $employess->code_employe,
                'date_time'     => $todayDate
            ];

            DB::table('user_activity_logs')->insert($activityLog);
            $employess->delete();

            DB::commit();
            Alert::success('Success', 'Data ' . $employess->name .' berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data ' . $employess->name . ' gagal dihapus');
            return redirect()->back();
        }
    }
}
