<?php

use App\Http\Controllers\LockScreen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logoutUser');
});

Route::controller(LockScreen::class)->group(function () {
    Route::get('lock_screen','lockScreen')->name('lock_screen');
    Route::post('unlock', 'unlock')->name('unlock');
});

// Register
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'storeUser')->name('registerUser');
});
// Forget Password

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('forget-password', 'getEmail')->name('forget-password-user');
    Route::post('forget-password', 'postEmail')->name('forget-password');
});

// Reset Password
Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('reset-password/{token}', 'getPassword');
    Route::post('reset-password', 'updatePassword');
});

Route::middleware('auth')->group(function(){
    Route::controller(UserManagementController::class)->group(function () {
        Route::get('userManagement', 'index')->name('userManagement');
        Route::post('user/add/save', 'addNewUserSave')->name('user/add/save');
        Route::post('update', 'update')->name('update');
        Route::post('user/delete', 'delete')->name('user/delete');
        Route::get('activity/log', 'activityLog')->name('activity/log');
        Route::get('activity/login/logout', 'activityLogInLogOut')->name('activity/login/logout');
    });

    Route::controller(UserManagementController::class)->group(function () {
        Route::get('change/password', 'changePasswordView')->name('change/password');
        Route::post('change/password/db', 'changePasswordDB')->name('change/password/db');
    });
});
