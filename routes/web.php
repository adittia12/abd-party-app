<?php

use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\LockScreen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Master\ProductController;
use App\Http\Controllers\Transaksi\InvoiceController;
use App\Http\Controllers\Transaksi\OrderController;
use App\Http\Controllers\Transaksi\ReportTransController;
use App\Http\Controllers\UserManagementController;

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
    return view('company_profile.company.index');
});

// Auth::rouwtes();


Auth::routes();
Route::controller(LoginController::class)->group(function() {
    Route::get('/login-abd', 'login')->name('login');
    Route::post('/login-abd', 'authenticate');
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
    Route::post('/reset-password', 'updatePassword');
});

Route::middleware('auth')->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
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

    Route::resource('/user_role', RoleUserController::class);
    Route::controller(RoleUserController::class)->group(function(){
        Route::post('/role/update_role', 'update')->name('updateRole');
    });

    // Master data
    Route::resource('/product', ProductController::class);
    Route::controller(ProductController::class)->group(function () {
        Route::post('/product/update', 'update')->name('updateProduct');
    });

    // Transaksi Order barang
    Route::resource('/order', OrderController::class);
    Route::controller(OrderController::class)->group(function () {
        Route::post('/autofill-product', 'autofillProduct')->name('order.autofill_product');
        Route::post('/autofill-product-order', 'autofillProductOrder')->name('order.autofill_product_order');
        Route::delete('/order/delete-transaction/{id}', 'deleteTransaction')->name('order.delete_transaction');
        Route::post('/order/update', 'update')->name('order.update_order_transaksi');
        Route::post('/order/approve_order', 'approveOrder')->name('order.approve_ok');
        Route::post('/order/approve_order_cancel', 'approveCancelOrder')->name('order.approve_cancel');
        Route::get('/order/cetak_order_trans/{id}', 'cetak_order')->name('order.cetak_order');
        Route::post('/order/approve-invoice', 'approveInvoice')->name('order.approve_invoice');
        Route::get('/order/cetak_invoice/{id}', 'cetakInvoice')->name('order.cetak_invoice');
        Route::post('/order/approve_surat_kembali', 'approveSuratKembali')->name('order.approveSuratKembali');
        Route::get('/order/cetak_surat_jalan/{id}', 'suratJalan')->name('order.suratJalan');
        Route::get('/order/cetak_surat_kembali/{id}', 'suratKembali')->name('order.suratKembali');
    });

    Route::resource('/invoice', InvoiceController::class);
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/cetak-invoice/{id}', 'cetakInvoice')->name('invoice.cetakInvoice');
        Route::post('/invoice/create-po', 'createPo')->name('invoice.create_po');
        Route::post('/invoice/update', 'update')->name('invoice.update_invo');
        Route::get('/invoice/doc-konsumen/{id}', 'docKonsumen')->name('invoice.doc-konsumen');
        Route::get('/invoice/doc-kantor/{id}', 'docKantor')->name('invoice.doc-kantor');
        Route::get('/invoice/doc-employee/{id}', 'docEmployee')->name('invoice.docEmployee');
    });

    Route::controller( ReportTransController::class)->group(function () {
        Route::get('/report/transaksi/', 'export')->name('export_transaksi');
    });

});


