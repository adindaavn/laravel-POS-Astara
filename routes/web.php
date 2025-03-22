<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\CekUserRole;
use App\Models\PengajuanBuku;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login/auth', [AuthController::class, 'auth'])->name('login.auth');

Route::middleware(['auth'], CekUserRole::class)->group(
    function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/home/transaksi-per-hari', [HomeController::class, 'getTransaksiPerHari']);
        Route::get('/home/dashboard-data', [HomeController::class, 'getDashboardData']);

        Route::resource('kategori', KategoriController::class);
        Route::resource('pemasok', PemasokController::class);
        Route::resource('buku', BukuController::class);
        Route::resource('member', MemberController::class);
        Route::resource('voucher', VoucherController::class);
        Route::resource('penjualan', PenjualanController::class);
        Route::resource('pembelian', PembelianController::class);
        
        Route::resource('pengajuan', PengajuanController::class);
        Route::get('/pengajuan/pdf', [PengajuanController::class, 'generatePDF']);
        Route::get('/pengajuan/excel', [PengajuanController::class, 'exportExcel']);
        Route::post('/pengajuan/update-status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    }
);
