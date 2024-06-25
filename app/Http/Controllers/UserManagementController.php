<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserManagementController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_name == 'Admin') {
            $result = DB::table('users')->get();
            $role_name = DB::table('role_type_users')->get();
            $status_user = DB::table('user_types')->get();

            return view('admin.user_management.user_control', compact(['result', 'role_name', 'status_user']));
        } else {
            return redirect()->route('home');
        }
    }

    public function activityLog()
    {
        $activityLog = DB::table('user_activity_logs')->orderBy('date_time', 'desc')->get();
        return view('admin.activity_user.user_activity_log',compact('activityLog'));
    }

    public function activityLogInLogOut()
    {
        $activityLog = DB::table('activity_logs')->get();
        return view('admin.activity_user.activity_log', compact('activityLog'));
    }

    // public function profile()
    // {
    //     $profile = Session::get('user_id');
    //     $userInformation =
    // }

    public function addNewUserSave(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'role_name'    => 'required|string|max:255',
            'status'       => 'required|string|max:255',
            'password'     => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $dt = Carbon::now('Asia/Jakarta');
            $todayDate = $dt->toDayDateTimeString();

            // $image = time() . '.' . $request->image->extension();
            // $request->image->move(public_path('assets/img'), $image);

            $user = new User;
            $user->name        = $request->name;
            $user->email       = $request->email;
            $user->join_date   = $todayDate;
            // $user->last_login   = $todayDate;
            $user->phone_number       = $request->phone_number;
            $user->role_name   = $request->role_name;
            $user->status      = $request->status;
            $user->avatar      = 'avatar-1.png';
            $user->password    = Hash::make($request->password);
            $user->save();
            // dd($check);
            DB::commit();
            Alert::success('Success', 'Create new account succesfully :)');

            return redirect()->route('userManagement');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            // die;
            DB::rollback();
            Alert::error('Error', 'User add new account fail :[');
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id        = $request->user_id;
            $name           = $request->name;
            $email          = $request->email;
            $role_name      = $request->role_name;
            $phone          = $request->phone;
            $status         = $request->status;

            $dt       = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();
            $image_name = $request->hidden_image;
            $image = $request->file('images');
            if($image_name =='avatar-1.png')
            {
                if($image != '')
                {
                    $image_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/admin/assets/img/avatar/'), $image_name);
                }
            }
            else{

                if($image != '')
                {
                    unlink('admin/assets/img/avatar/'.$image_name);
                    $image_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('/admin/assets/img/avatar/'), $image_name);
                }
            }

            $update = [
                'user_id'       => $user_id,
                'name'          => $name,
                'role_name'     => $role_name,
                'email'         => $email,
                'phone_number'  => $phone,
                'status'        => $status,
                'avatar'        => $image_name
            ];

            $activityLog = [
                'user_name'     => $name,
                'email'         => $email,
                'phone_number'  => $phone,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Update',
                'date_time'     => $todayDate
            ];

            DB::table('user_activity_logs')->insert($activityLog);
            User::where('user_id', $request->user_id)->update($update);
            DB::commit();
            Alert::success('Success', 'User updated successfully :)');

            return redirect()->route('userManagement');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Wrong', 'User update fail :[');
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        Session::put('user', $user);
        $user = Session::get('user');
        DB::beginTransaction();
        try {
            $fullName       = $user->name;
            $email          = $user->email;
            $phone_number   = $user->phone_number;
            $status         = $user->status;
            $role_name      = $user->role_name;

            $dt         = Carbon::now('Asia/Jakarta');
            $todayDate  = $dt->toDayDateTimeString();

            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'phone_number'  => $phone_number,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Delete',
                'date_time'     => $todayDate
            ];

            DB::table('user_activity_logs')->insert($activityLog);

            if ($request->avatar == 'avatar-1.png') {
                User::destroy($request->id);
            } else {
                User::destroy($request->id);
                unlink('admin/assets/img/avatar/' . $request->avatar);
            }

            DB::commit();
            Alert::success('Success', 'User deleted successfully :)');
            return redirect()->route('userManagement');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error!', 'User deleted fail :)');
            return redirect()->back();
        }
    }

    public function changePasswordView()
    {
        return view('settings.changePassword');
    }

    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password'     => ['required', 'min:8'],
            'new_confirm_password' => ['required', 'same:new_password']
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);
        DB::commit();
        Alert::success('Success', 'Password changed successfully');
        return redirect()->intended('home');
    }
}
