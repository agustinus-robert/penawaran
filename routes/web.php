<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefPerusahaanController;
use App\Http\Controllers\RefTipePekerjaanController;
use App\Http\Controllers\RefUserController;
use App\Http\Controllers\RefClientController;
use App\Http\Controllers\PenawaranJasaController;
use App\Http\Controllers\ApprovePenawaranController;
use App\Http\Controllers\PermintaanJasaController;
use App\Http\Controllers\PermintaanJasaApproveController;
use App\Http\Controllers\PesananPembelianController;
use App\Http\Controllers\PembayaranPembelianController;


Route::get('/', function() {
    return Redirect::route('login');
});

Route::group(['middleware' => 'web'], function(){
    Auth::routes();

//    Route::get('/', [App\Http\Controllers\Auth\LoginController::class]);

    Route::get('locale/{locale}', function ($locale) {
        if (! in_array($locale, ['en', 'id'])) {
            abort(400);
        }

        app()->setLocale($locale);
        Session::put('locale', $locale);
        return redirect()->back();
    })->name('locale');
    


    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'index']);
    Route::get('ref_pekerjaan/select', [App\Http\Controllers\RefTipePekerjaanController::class,'select']);
    Route::get('ref_perusahaan/select', [App\Http\Controllers\RefPerusahaanController::class,'select']);
    Route::get('ref_user/select', [App\Http\Controllers\RefUserController::class,'select']);
    //seperate method resources
    Route::resources([
        'ref_user' => RefUserController::class,
        'ref_perusahaan' => RefPerusahaanController::class,
        'ref_pekerjaan' => RefTipePekerjaanController::class,
        'ref_client' => RefClientController::class,
        'penawaran_jasa' => PenawaranJasaController::class,
        'approve_penawaran_jasa' => ApprovePenawaranController::class,
        'permintaan_jasa' =>  PermintaanJasaController::class,
        'approve_permintaan_jasa' => PermintaanJasaApproveController::class,
        'pesanan_pembelian' => PesananPembelianController::class,
        'pembayaran_pembelian' => PembayaranPembelianController::class
    ]);
});