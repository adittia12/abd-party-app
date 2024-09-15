<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Models\ServiceArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ServiceArea\ServiceAreaStoreRequest;
use App\Http\Requests\ServiceArea\ServiceAreaUpdateRequest;

class ServiceAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $servicesArea = ServiceArea::when(request('q'), function($query) {
            $search = request('q');
            return $query->where(function($q) use ($search) {
                $q->where('area', 'like', '%' . $search . '%');
            });
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.serviceArea.index', compact('servicesArea'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceAreaStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $createServiceArea = new ServiceArea;
            $createServiceArea->area = $request->input('area');
            $createServiceArea->save();

            DB::commit();
            Alert::success('Success', 'Wilayah pelayanan berhasil ditambah!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal menambahkan wilayah pelayanan!');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceAreaUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            // Dekripsi ID jika ID terenkripsi
            $decryptedId = decrypt($request->id_updateServiceArea);

            // Cari service area berdasarkan ID
            $updateServiceArea = ServiceArea::find($decryptedId);

            // Periksa apakah data ditemukan
            if (!$updateServiceArea) {
                DB::rollBack();
                Alert::error('Error', 'Wilayah pelayanan tidak ditemukan!');
                return redirect()->back();
            }

            // Data yang akan diupdate
            $update = [
                'area' => $request->area,
            ];

            // Update data service area
            $updateServiceArea->update($update);

            DB::commit();
            Alert::success('Success', 'Wilayah pelayanan berhasil diubah!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal mengubah wilayah pelayanan! '); // Tambahkan detail error
            return redirect()->back();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($serviceArea)
    {
        DB::beginTransaction();
        try {
            $serviceAreaData = ServiceArea::findOrFail($serviceArea);
            $serviceAreaData->delete();
            DB::commit();
            Alert::success('Success', 'Wilayah pelayanan berhasil dihapus!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Gagal menghapus wilayah pelayanan! ');
            return redirect()->back();
        }
    }
}
