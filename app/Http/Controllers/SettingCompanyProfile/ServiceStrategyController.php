<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Models\ServiceStrategies;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ServiceStrategyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $serviceStrategy = ServiceStrategies::when(request('q'), function($query) {
            $search = request('q');
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.ServiceStrategy.index', compact(['serviceStrategy']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ]);
        DB::beginTransaction();
        try {
            $createServiceStrategy = new ServiceStrategies;
            $createServiceStrategy->title = $request->input('title');
            $createServiceStrategy->description = $request->input('description');
            $createServiceStrategy->save();
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
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
        ]);

        DB::beginTransaction();

        try {
            $decryptedId = decrypt($request->id_update_serviceStrategy);
            $updateServiceStrategy = ServiceStrategies::find($decryptedId);

            if (!$updateServiceStrategy) {
                DB::rollBack();
                Alert::error('Error', 'Data tidak ditemukan');
                return redirect()->back();
            }

            $update = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ];

            $updateServiceStrategy->update($update);
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
    public function destroy($serviceStrategy)
    {
        DB::beginTransaction();
        try {
            $serviceStrategiesData = ServiceStrategies::findOrFail($serviceStrategy);
            $serviceStrategiesData->delete();
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
