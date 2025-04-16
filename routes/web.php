<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\exportLaporan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\importLaporan;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\VoucherController;
use App\Http\Middleware\CekUserRole;
use App\Models\Absensi;
use App\Models\PengajuanBuku;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login/auth', [AuthController::class, 'auth'])->name('login.auth');

Route::middleware(['auth'], CekUserRole::class)->group(
    function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/home/daily-penjualan', [HomeController::class, 'dailyPenjualan'])->name('daily-penjualan');
        Route::get('/home/daily-pembelian', [HomeController::class, 'dailyPembelian'])->name('daily-pembelian');

        Route::resource('kategori', KategoriController::class);
        Route::resource('pemasok', PemasokController::class);
        Route::resource('buku', BukuController::class);
        Route::resource('member', MemberController::class);
        Route::resource('voucher', VoucherController::class);
        Route::resource('penjualan', PenjualanController::class);
        Route::resource('pembelian', PembelianController::class);
        
        Route::resource('pengajuan', PengajuanController::class);
        Route::post('/pengajuan/update-status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');
        
        Route::resource('absensi', AbsensiController::class);
        Route::post('/absensi/update-status', [AbsensiController::class, 'updateStatus'])->name('absensi.updateStatus');
        Route::post('/absensi/selesai-kerja', [AbsensiController::class, 'selesaiKerja'])->name('absensi.selesaiKerja');

        Route::get('/export/pdf', [exportLaporan::class, 'exportPDF'])->name('export.pdf');
        Route::get('/export/excel', [exportLaporan::class, 'exportExcel'])->name('export.excel');
        Route::post('/import/excel', [importLaporan::class, 'importExcel'])->name('import.excel');
        Route::get('/import/format-excel', [importLaporan::class, 'formatImport'])->name('import.format-excel');
        
        Route::get('/buku/cari-isbn/${isbn}', [BukuController::class, 'cariIsbn'])->name('buku.cari-isbn');
    }
);
