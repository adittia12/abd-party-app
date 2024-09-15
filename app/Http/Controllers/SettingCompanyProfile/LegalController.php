<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Models\DocumentsLegal;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

class LegalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $legalData = DocumentsLegal::when(request('q'), function($query) {
            return $query->where('title', 'like', '%' . request('q') . '%');
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.legal.index', compact(['legalData']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'document' => 'mimes:jpg,jpeg,png|max:2048',
        ], [
            'title.required' => 'Title is required',
            'document.mimes' => 'Document must be in jpg, jpeg, png format',
            'document.max' => 'Document size must not exceed 2MB',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('document') && $request->file('document')->isValid()) {
                $path = $request->file('document')->store('legal', 'public');
            } else {
                $path = 'legal/default.jpg';
            }

            $dataLegal = new DocumentsLegal;
            $dataLegal->title = $request->input('title');
            $dataLegal->document = $path;
            $dataLegal->save();
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
            'document' => 'mimes:jpg,jpeg,png|max:2048',
        ], [
            'title.required' => 'Title is required',
            'document.mimes' => 'Document must be in jpg, jpeg, png format',
            'document.max' => 'Document size must not exceed 2MB',
        ]);

        DB::beginTransaction();

        try {
            $decryptedId = decrypt($request->input('id_update_legal'));
            $dataLegal = DocumentsLegal::findOrFail($decryptedId);

            if ($request->hasFile('document')) {
                if ($dataLegal->document && Storage::exists($dataLegal->document)) {
                    Storage::delete($dataLegal->document);
                }
                $path = $request->file('document')->store('legal', 'public');
            } else {
                $path = $dataLegal->document;
            }

            $dataLegal->update([
                'title' => $request->input('title'),
                'document' => $path,
            ]);
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
    public function destroy($legals)
    {
        DB::beginTransaction();

        try {
            $legalDelete = DocumentsLegal::where('id', $legals)->firstOrFail();
            if ($legalDelete->document && Storage::exists($legalDelete->document)) {
                Storage::delete($legalDelete->document);
            }
            $legalDelete->delete();
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
