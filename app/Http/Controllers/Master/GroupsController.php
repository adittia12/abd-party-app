<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Groupss;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $dataGroup = Groupss::when(request('q'), function($query)  {
            $search = request('q');
            return $query->where(function($q) use ($search){
                $q->where('name_group', 'like', '%' . $search . '%');
            });
        })->latest()->paginate($perPage);

        return view('master.groups.index', compact(['dataGroup']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            ['name_group' => 'required'],
            ['name_group.required' => 'Nama group wajib diisi']
        );

        DB::beginTransaction();
        try {
            $group = new Groupss;
            $group->name_group = $request->name_group;
            $group->save();
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
    public function updateGroup(Request $request)
    {
        $request->validate(
            ['name_group' => 'required'],
            ['name_group.required' => 'Nama group wajib diisi']
        );

        DB::beginTransaction();
        try {
            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $update = [
                'name_group' => $request->name_group
            ];

            $activityLog = [
                'user_name'   => Auth::user()->name,
                'email'       => Auth::user()->email,
                'status'      => Auth::user()->status,
                'role_name'   => Auth::user()->role_name,
                'modify_user' => 'Ubah data group ' . $request->name_group,
                'date_time'   => $todayDate,
            ];

            // Pengecekan apakah data di variabel $update dan $activityLog lengkap
            $isUpdateDataComplete = !in_array(null, $update) && !in_array('', $update);
            $isActivityLogComplete = !in_array(null, $activityLog) && !in_array('', $activityLog);

            if ($isUpdateDataComplete && $isActivityLogComplete) {
                DB::table('user_activity_logs')->insert($activityLog);
                Groupss::where('id', decrypt($request->code_id_group))->update($update);
                DB::commit();
                Alert::success('Success', 'Data ' . $request->name_group . ' berhasil diubah');
                return redirect()->back();
            } else {
                DB::rollBack();
                Alert::error('Error', 'Data gagal diubah');
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Wrong', 'Data ' . $request->name_group . ' gagal diubah');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($group)
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

            $groups = Groupss::where('id', decrypt($group))->first();

            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Delete data group ' . $groups->name_group,
                'date_time'     => $todayDate
            ];

            DB::table('user_activity_logs')->insert($activityLog);
            $groups->delete();
            DB::commit();
            Alert::success('Success', 'Data ' . $groups->name_group . ' berhasil dihapus.');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Wrong', 'Data gagal dihapus');
            return redirect()->back();
        }
    }
}
