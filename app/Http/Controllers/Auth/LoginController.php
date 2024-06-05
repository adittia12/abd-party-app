<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $username = $request->email;
        $password = $request->password;
        $dt = Carbon::now('Asia/Jakarta');
        $todayDate = $dt->toDayDateTimeString();

        if (Auth::attempt(['email' => $username, 'password' => $password, 'status' => 'Active'])) {
            // Get Session
            $user = Auth::user();
            Session::put('name', $user->name);
            Session::put('email', $user->email);
            Session::put('user_id', $user->user_id);
            Session::put('join_date', $user->join_date);
            Session::put('phone_number', $user->phone_number);
            Session::put('status', $user->status);
            Session::put('role_name', $user->role_name);
            Session::put('avatar', $user->avatar);

            $activityLog = ['name' => Session::get('name'), 'email' => $username, 'description' => 'Has Log in', 'date_time' => $todayDate];
            DB::table('activity_logs')->insert($activityLog);

            Alert::success('Congrats', 'Login successfully :)');
            return redirect()->route('home');
        } else {
            Alert::error('Oops!', 'Invalid email or password :(')->persistent("Close");
            return redirect('login');
        }
    }

    public function logout(Request $request)
    {
        $dt = Carbon::now('Asia/Jakarta');
        $todayDate = $dt->toDayDateTimeString();

        $activityLog = ['name' => Session::get('name'), 'email' => Session::get('email'), 'description' => 'Has log out', 'date_time' => $todayDate];

        DB::table('activity_logs')->insert($activityLog);

        // forget login session
        $request->session()->forget('name');
        $request->session()->forget('email');
        $request->session()->forget('user_id');
        $request->session()->forget('join_date');
        $request->session()->forget('phone_number');
        $request->session()->forget('status');
        $request->session()->forget('role_name');
        $request->session()->forget('avatar');
        $request->session()->flush();

        Auth::logout();
        // if (Auth::logout()) {
            Alert::success('Congrats', 'Logout successfully :)');
        // }
        return redirect()->route('login');
    }
}
