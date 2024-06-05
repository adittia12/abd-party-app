<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class LockScreen extends Controller
{
    public function lockScreen()
    {
        if (!session('lock-expires-at')) {
            return redirect('dashboard.main_dashboard');
        }

        if (session('lock-expires-at') > now()) {
            return redirect('dashboard.main_dashboard');
        }

        return view('lockscreen.lockscreen');
    }

    public function unlock(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $check = Hash::check($request->input('password'), $request->user()->password);

        if (!$check) {
            Alert::error('Wrong!', 'Your password does not match :[');
        }
        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
        return redirect('dashboard.main_dashboard');
    }
}
