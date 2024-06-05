<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    public function register()
    {
        $role = DB::table('role_type_users')->get();
        return view('auth.register', $role);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'role_name' => 'required|string|max:255',
            'password'  => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $dt       = Carbon::now('Asia/Jakarta');
        $todayDate = $dt->toDayDateTimeString();

        $save = User::create([
                'name'      => $request->name,
                'avatar'    => $request->image,
                'email'     => $request->email,
                'join_date' => $todayDate,
                'role_name' => $request->role_name,
                'status'    => 'Active',
                'password'  => Hash::make($request->password),
            ]);
        if($save){
            Alert::success('Congrats', 'You\'ve login in system application');
            return redirect()->route('login');
        } else {
            Alert::error('Oops', 'Something went wrong! Please try again later');
            return redirect()->route('register');
        }
    }
}
