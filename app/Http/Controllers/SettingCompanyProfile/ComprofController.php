<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Comentars;
use App\Models\DocumentsLegal;
use App\Models\Gallerys;
use App\Models\PhotoService;
use App\Models\ServiceArea;
use App\Models\Services;
use App\Models\ServiceStrategies;
use App\Models\WorkforeceSkills;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ComprofController extends Controller
{
    public function index()
    {
        $dataClient = Clients::select(['client_name', 'image'])
                        ->orderBy('created_at', 'desc')
                        ->limit(6)
                        ->get();

        $dataService = PhotoService::join('services', 'photo_service.id_service', '=', 'services.id')
                    ->select(['photo_service.name_photo', 'services.title', 'services.slug', 'services.description'])
                    ->orderBy('services.created_at', 'desc')
                    ->get();

        $dataServiceArea = ServiceArea::all();
        $dataServiceStrategy = ServiceStrategies::all();
        $dataSkill = WorkforeceSkills::all();

        $dataGallery = Gallerys::select(['title', 'image'])
                    ->orderBy('created_at', 'desc')
                    ->limit(12)
                    ->get();

        $dataComentar = Comentars::select(['title', 'name', 'description'])
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();

        $dataLegal = DocumentsLegal::select(['title', 'document'])
                                ->orderBy('created_at', 'asc')
                                ->get();

        return view('company_profile.company.index', compact(['dataClient', 'dataService', 'dataServiceArea', 'dataServiceStrategy', 'dataSkill', 'dataGallery', 'dataComentar', 'dataLegal']));
    }

    public function storeComentar(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'description' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $createComentar = new Comentars;
            $createComentar->title = $request->title;
            $createComentar->name = $request->name;
            $createComentar->description = $request->description;
            $createComentar->save();
            DB::commit();
            Alert::success('Success', 'Komentar berhasil dikirim');
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('Error', 'Komentar gagal dikirim');
            return redirect()->back();
        }
    }
}
