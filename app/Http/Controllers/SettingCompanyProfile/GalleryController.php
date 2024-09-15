<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Models\Gallerys;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $galleryData = Gallerys::when(request('q'), function($query) {
            return $query->where('title', 'like', '%' . request('q') . '%');
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.gallery.index', compact(['galleryData']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
        ], [
            'title.required' => 'Title is required',
            'image.mimes' => 'Image must be in jpg, jpeg, png format',
            'image.max' => 'Image size must not exceed 2MB',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $path = $request->file('image')->store('gallery', 'public');
            } else {
                $path = 'gallery/default.png';
            }
            $dataGallery = new Gallerys;
            $dataGallery->title = $request->input('title');
            $dataGallery->image = $path;
            $dataGallery->save();
            DB::commit();
            Alert::success('Success', 'Data Berhasil ditambah');
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
        // Validate input data
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'title.required' => 'Title is required',
            'title.max' => 'Title must not exceed 255 characters',
            'image.mimes' => 'Image must be in jpg, jpeg, or png format',
            'image.max' => 'Image size must not exceed 2MB',
        ]);

        DB::beginTransaction();

        try {
            // Decrypt and find the gallery data
            $decryptedId = decrypt($request->input('id_update_gallery'));
            $dataGallery = Gallerys::findOrFail($decryptedId);

            // Handle image upload if a new image is provided
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($dataGallery->image && Storage::exists($dataGallery->image)) {
                    Storage::delete($dataGallery->image);
                }

                // Store the new image
                $file = $request->file('image')->store('gallery', 'public');
            } else {
                $file = $dataGallery->image; // Keep the existing image
            }

            // Update gallery data
            $dataGallery->update([
                'title' => $request->input('title'),
                'image' => $file,
            ]);

            DB::commit();
            Alert::success('Success', 'Data successfully updated');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Data update failed');
            return redirect()->back()->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($gallery)
    {
        DB::beginTransaction();

        try {
            $galleryDelete = Gallerys::where('id', $gallery)->firstOrFail();
            if ($galleryDelete->image) {
                Storage::delete($galleryDelete->image);
            }
            $galleryDelete->delete();
            DB::commit();
            Alert::success('Success', 'Data Berhasil dihapus');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Data gagal dihapus');
            return redirect()->back();
        }
    }
}
