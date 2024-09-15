<?php

namespace App\Http\Controllers\SettingCompanyProfile;

use App\Http\Controllers\Controller;
use App\Models\WorkforeceSkills;
use DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $skillWork = WorkforeceSkills::when(request('q'), function($query) {
            $search = request('q');
            return $query->where(function($q) use ($search) {
                $q->where('skill', 'like', '%'. $search . '%');
            });
        })->latest()->paginate($perPage);

        return view('admin.sett_company_profile.skills.index', compact(['skillWork']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'skill' => 'required'
        ], [
            'skill.required' => 'Skill wajib diisi'
        ]);

        DB::beginTransaction();

        try {
            $createSkill = new WorkforeceSkills;
            $createSkill->skill = $request->input('skill');
            $createSkill->save();

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
            'skill' => 'required'
        ], [
            'skill.required' => 'Skill wajib diisi'
        ]);

        DB::beginTransaction();
        try {
            $decryptedId = decrypt($request->id_skill);

            $updateSkill = WorkforeceSkills::find($decryptedId);

            if (!$updateSkill) {
                DB::rollBack();
                Alert::error('Error', 'Data tidak ditemukan');
                return redirect()->back();
            }

            $update = [
                'skill' => $request->skill
            ];

            $updateSkill->update($update);
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
    public function destroy($workforeceSkill)
    {
        DB::beginTransaction();

        try {
            $skillData = WorkforeceSkills::findOrFail($workforeceSkill);
            $skillData->delete();
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
