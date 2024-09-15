<?php

namespace App\Http\Controllers\Master;

use Carbon\Carbon;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Master\ProductStoreRequest;
use App\Http\Requests\Master\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $product = Products::when(request('q'), function($query) {
            $search = request('q');
            return $query->where(function($q) use ($search) {
                $q->where('inter_ref', 'like', '%' . $search . '%')
                  ->orWhere('name_product', 'like', '%' . $search . '%');
            });
        })->latest()->paginate($perPage);

        return view('master.product.index', compact(['product']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = new Products;
            $product->name_product     = $request->name_product;
            $product->sales_price      = $request->sales_price;
            $product->unit_measure     = $request->unit_measure;
            $product->save();

            DB::commit();
            Alert::success('Success', 'Product berhasil ditambah :)');

            return redirect()->route('product.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Error', 'Product gagal ditambahkan :[');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();

            $update = [
                'inter_ref'    => $request->inter_ref,
                'name_product' => $request->name_product,
                'sales_price'   => $request->sales_price,
                'unit_measure' => $request->unit_measure,
            ];

            $activityLog = [
                'user_name'   => Auth::user()->name,
                'email'       => Auth::user()->email,
                'status'      => Auth::user()->status,
                'role_name'   => Auth::user()->role_name,
                'modify_user' => 'Update data product ' . $request->inter_ref,
                'date_time'   => $todayDate,
            ];

            // Pengecekan apakah data di variabel $update dan $activityLog lengkap
            $isUpdateDataComplete = !in_array(null, $update) && !in_array('', $update);
            $isActivityLogComplete = !in_array(null, $activityLog) && !in_array('', $activityLog);

            if ($isUpdateDataComplete && $isActivityLogComplete) {
                DB::table('user_activity_logs')->insert($activityLog);
                Products::where('inter_ref', $request->inter_ref)->update($update);
                DB::commit();
                Alert::success('Success', 'Data produk ' . $request->inter_ref . ' berhasil diperbarui :)');
                return redirect()->route('product.index');
            } else {
                Alert::error('Failed', 'Data produk tidak lengkap dan tidak berhasil disimpan');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Wrong', 'Data produk ' . $request->inter_ref . ' gagal diperbarui :[');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {
        $user = Auth::user();
        Session::put('user', $user);
        $user = Session::get('user');
        DB::beginTransaction();
        try {
            $fullName       = $user->name;
            $email          = $user->email;
            $status         = $user->status;
            $role_name      = $user->role_name;

            $dt         = Carbon::now('Asia/Jakarta');
            $todayDate  = $dt->toDayDateTimeString();
            $products = Products::where('inter_ref', $product)->first();

            $activityLog = [
                'user_name'     => $fullName,
                'email'         => $email,
                'status'        => $status,
                'role_name'     => $role_name,
                'modify_user'   => 'Delete data product ' . $products->inter_ref,
                'date_time'     => $todayDate
            ];

            DB::table('user_activity_logs')->insert($activityLog);

            $products->delete();

            DB::commit();
            Alert::success('Success', 'Data product '. $products->inter_ref .' berhasil dihapus :)');
            return redirect()->route('product.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error!', 'Data gagal dihapus :)');
            return redirect()->back();
        }
    }
}
