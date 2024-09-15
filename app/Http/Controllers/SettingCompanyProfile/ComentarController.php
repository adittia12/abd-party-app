<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Models\Comentars;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ComentarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $dataComentar = Comentars::when(request('q'), function($query) {
            $search = request('q');
            return $query->where('title', 'like', '%' . request('q') . '%')
                    ->orWhere('name', 'like', '%' . request('q') . '%');
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.comentar.index', compact(['dataComentar']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($comentar)
    {
        DB::beginTransaction();

        try {
            $comentarData = Comentars::findOrFail($comentar);
            $comentarData->delete();
            DB::commit();
            Alert::success('Success', 'Data berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data gagal dihapus');
            return redirect()->back();
        }
    }
}
