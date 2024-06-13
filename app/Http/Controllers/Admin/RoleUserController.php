<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Products;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = UserRole::all();

        return view('admin.role_user.index', compact(['role']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = new UserRole;
            $role->role_type = $request->role_type;
            $role->save();

            DB::commit();
            Alert::success('Success', 'Role '. $request->role_type .' berhasil ditambah :)');
            return redirect()->route('user_role.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'User role gagal ditambahkan :[');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'role_type' => $request->role_type
            ];

            // Pastikan role dengan id tersebut ada
            $role = UserRole::find($request->id_role);

            // Update role
            $role->update($data);

            DB::commit();
            Alert::success('Success', 'Data role berhasil diperbarui.');
            return redirect()->route('user_role.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            // Menampilkan pesan kesalahan yang lebih spesifik
            Alert::error('Error', 'Data role gagal diperbarui');
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userRoles)
    {
        DB::beginTransaction();
        try {
            $role = UserRole::where('id', $userRoles)->first();
            $role->delete();
            DB::commit();
            Alert::success('Success', 'Role '. $role->role_type .' berhasil dihapus.');
            return redirect()->route('user_role.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error!', 'Role ' . $role->role_type . ' gagal dihapus.');
            return redirect()->back();
        }
    }
}
