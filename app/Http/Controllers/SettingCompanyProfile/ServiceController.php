<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\PhotoService;
use App\Models\Services;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $serviceData = Services::join('photo_service', 'services.id', '=', 'photo_service.id_service')
                                ->select('services.title', 'services.slug', 'services.description', 'photo_service.name_photo', 'services.id as service_id')
                                ->when(request('q'), function ($query){
                                    return $query->where('services.title', 'like', '%' . request('q') . '%');
                                })->latest('services.created_at')->paginate($perPage);

        return view('admin.sett_company_profile.service.index', compact('serviceData'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $dataService = new Services;

            // Membuat slug dari title
            $slug = $request->slug ?: Str::slug($request->title);

            // Cek apakah slug sudah ada di database
            $originalSlug = $slug;
            $counter = 1;
            while (Services::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Assign slug unik ke data service
            $dataService->title = $request->title;
            $dataService->slug = $slug;
            $dataService->description = $request->description;
            $dataService->save();

            // Menyimpan file foto jika ada, atau menggunakan default
            if ($request->hasFile('name_photo') && $request->file('name_photo')->isValid()) {
                $path = $request->file('name_photo')->store('service', 'public');
            } else {
                $path = 'service/default.png';
            }

            // Menyimpan data foto ke tabel PhotoService
            PhotoService::create([
                'id_service' => $dataService->id,
                'name_photo' => $path,
            ]);

            DB::commit();
            Alert::success('Success', 'Pelayanan berhasil ditambah!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Pelayanan gagal ditambah!');
            return redirect()->back()->withInput(); // Mengembalikan input jika ada error
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            // Dekripsi ID yang terenkripsi
            $decryptedId = decrypt($request->id_updateservice);

            // Cari service berdasarkan ID
            $serviceUpdate = Services::where('id', $decryptedId)->firstOrFail();

            // Update data service
            $update = [
                'title' => $request->title,
                'slug' => $request->slug_service,
                'description' => $request->description,
            ];

            // Inisialisasi photoService
            $photoService = PhotoService::where('id_service', $serviceUpdate->id)->first();

            if ($request->hasFile('name_photo')) {
                // Hapus gambar lama
                if ($photoService && $photoService->name_photo) {
                    Storage::delete($photoService->name_photo);
                }

                // Simpan gambar baru
                $file = $request->file('name_photo')->store('service', 'public');
            } else {
                // Jika tidak ada file baru, gunakan file lama
                $file = $photoService->name_photo ?? null;
            }

            // Update service data
            $serviceUpdate->update($update);

            // Update photo service
            PhotoService::updateOrCreate(
                ['id_service' => $serviceUpdate->id],
                ['name_photo' => $file]
            );

            DB::commit();
            Alert::success('Success', 'Pelayanan berhasil diupdate!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Pelayanan gagal diupdate! ');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        DB::beginTransaction();

        try {
            // Cari service berdasarkan slug
            $serviceDelete = Services::where('slug', $slug)->firstOrFail();

            // Hapus service
            $serviceDelete->delete();

            DB::commit();
            Alert::success('Success', 'Pelayanan berhasil dihapus!');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Pelayanan gagal dihapus! ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
