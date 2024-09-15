<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ClientsStoreRequest;
use App\Http\Requests\ClientsUpdateRequest;
use Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default 10 jika tidak ada input
        // Mengambil data dengan kondisi pencarian dan pagination
        $clientData = Clients::when(request('q'), function($query) {
            return $query->where('client_name', 'like', '%' . request('q') . '%');
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.clients.index', compact('clientData'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientsStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $client = new Clients;
            $client->client_name = $request->client_name;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // Menggunakan metode file() yang benar untuk mendapatkan file
                $path = $request->file('image')->store('clients', 'public'); // Simpan file di folder 'clients' dalam storage 'public'
            } else {
                $path = null; // Jika tidak ada file yang diunggah atau tidak valid, set path menjadi null
            }

            $client->image = $path; // Set atribut 'image' pada model Clients
            $client->save(); // Simpan model ke database

            DB::commit();
            Alert::success('Success', 'Client berhasil ditambah!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Client gagal ditambah!');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientsUpdateRequest $request)
    {
        DB::beginTransaction();

        try {
            // Cari client yang ingin di-update berdasarkan ID dari request
            $clientUpdate = Clients::findOrFail(decrypt($request->client_id));

            $update = [
                'client_name' => $request->client_name,
            ];

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada dan simpan gambar baru
                Storage::delete($clientUpdate->image);
                $file = $request->file('image')->store('clients', 'public');
                $update['image'] = $file;
            }

            // Update hanya jika ada perubahan
            if (!empty($update)) {
                $clientUpdate->update($update);
            }

            DB::commit();
            Alert::success('Success', 'Client berhasil diupdate!');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Client gagal diupdate!');
            return redirect()->back();
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($client)
    {
        DB::beginTransaction();
        try {
            $clientDelete = Clients::findOrFail($client);
            $clientDelete->delete();
            DB::commit();
            Alert::success('Success', 'Client berhasil dihapus!');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            Alert::error('Error', 'Client gagal dihapus!');
            return redirect()->back();
        }
    }
}
