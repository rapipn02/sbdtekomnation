<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarDonasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RiwayatDonasiController;
use App\Http\Controllers\VerifikasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\UserController;


// HALAMAN UNTUK TAMU (BELUM LOGIN)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('login');
    Route::post('/', [AuthController::class, 'authenticate']);
    
    Route::get('/registrasi', function () {
        return view('registrasi.index');
    });
    Route::post('/register', [RegisterController::class, 'store']);
});


// HALAMAN & PROSES YANG MEMBUTUHKAN LOGIN (SEMUA JENIS USER)
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    // Proses Verifikasi Email
    Route::get('/email/verify/verification', [VerifikasiController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerifikasiController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::get('/email/verify/resend-verifikasi', [VerifikasiController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');

    // Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // === PERBAIKAN DI SINI ===
    // Pindahkan route untuk API grafik dan filter ke dalam grup 'auth'
    // agar hanya bisa diakses oleh user yang sudah login.
    Route::get('/grafik-donasi', [DashboardController::class, 'grafik'])->name('donasi.grafik');
    Route::get('/filter-donasi', [DashboardController::class, 'filterDonasi'])->name('donasi.filter');
    // =========================
});


// HALAMAN KHUSUS ADMIN
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('/kategori', KategoriController::class);
        Route::resource('/daftar-donasi', DaftarDonasiController::class);
        Route::get('/riwayat-donasi', [RiwayatDonasiController::class, 'index']);
        
        // Diubah dari '/user' menjadi '/users' agar konsisten
        Route::resource('/users', UserController::class); 

        Route::resource('/pengeluaran', PengeluaranController::class);
    });
    Route::get('/api/donasi/{daftarDonasi}/total', [DaftarDonasiController::class, 'getTotalDonasi']);
});

// HALAMAN KHUSUS PENGGUNA BIASA
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user-donasi', [MemberController::class, 'index']);
    Route::get('/user-donasi/{daftardonasi}', [MemberController::class, 'show']);
    Route::post('/user-donasi/kirim-donasi', [MemberController::class, 'kirimDonasi']);
    Route::post('/user-donasi/notification', [MemberController::class, 'notifikasi']);
    Route::get('/riwayat/invoice/{kode}', [MemberController::class, 'invoiceDetail']);
    Route::get('/riwayat/invoice', [MemberController::class, 'invoice']);
    Route::get('/invoice/print/{kode}', [MemberController::class, 'printInvoice']);
    Route::get('/laporan-pengeluaran', [MemberController::class, 'laporanPengeluaran'])->name('user.laporan.index');
});

