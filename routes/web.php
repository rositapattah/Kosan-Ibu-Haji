<?php

use App\Http\Controllers\KamarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenghuniController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home'])->name('index');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class,'dashboard'])->name('user.dashboard');
    Route::resource('/kamar', KamarController::class);
    Route::resource('/laporan', LaporanController::class);
    Route::post('/tagihan/bayar_manual/{id}', [TagihanController::class, 'bayar_manual'])->name('tagihan.bayar_manual');
    Route::post('/tagihan/konfirmasi_manual/{id}', [TagihanController::class, 'konfirmasi_manual'])->name('tagihan.konfirmasi_manual');
    // Tambahkan route ini untuk method checkout
    Route::get('/tagihan/{tagihan}/checkout', [TagihanController::class, 'checkout'])->name('tagihan.checkout');
    // Tambahkan route ini untuk method showResi
    Route::get('/tagihan/resi/{id}', [TagihanController::class, 'showResi'])->name('tagihan.resi');
    Route::resource('/pembayaran', PembayaranController::class)->only('index');
    Route::resource('/tagihan', TagihanController::class);
    Route::resource('/penghuni', PenghuniController::class);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
