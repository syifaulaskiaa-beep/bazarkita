<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\NotifikasiController;
use App\Models\Tenant;

Route::get('/', function () { return view('beranda'); });

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return app(App\Http\Controllers\AdminController::class)->dashboard();
    }
    // Panggil fungsi dashboard dari TenantController
    return app(App\Http\Controllers\TenantController::class)->dashboard();
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Rute Tenant
    Route::get('/tenant/profil', [TenantController::class, 'edit'])->name('tenant.profil');
    Route::post('/tenant/profil', [TenantController::class, 'update'])->name('tenant.profil.update');
    Route::get('/tenant/event', [EventController::class, 'index'])->name('tenant.event');
    Route::get('/tenant/daftar/{event}', [PendaftaranController::class, 'create'])->name('tenant.daftar');
    Route::post('/tenant/daftar/{event}', [PendaftaranController::class, 'store'])->name('tenant.daftar.store');
    Route::get('/tenant/pendaftaran', [PendaftaranController::class, 'index'])->name('tenant.status');
    Route::post('/tenant/bayar/{pendaftaran}', [PendaftaranController::class, 'bayar'])->name('tenant.bayar');
    Route::get('/tenant/produk', [ProdukController::class, 'index'])->name('tenant.produk');
    Route::post('/tenant/produk', [ProdukController::class, 'store'])->name('tenant.produk.store');
    Route::delete('/tenant/produk/{id}', [ProdukController::class, 'destroy'])->name('tenant.produk.destroy');
    Route::get('/tenant/notifikasi', [NotifikasiController::class, 'index'])->name('tenant.notifikasi');

    // Rute Admin
    Route::prefix('admin')->group(function () {
        Route::get('/pendaftaran', [AdminController::class, 'pendaftaran'])->name('admin.pendaftaran');
        Route::post('/pendaftaran/{id}/setujui', [AdminController::class, 'setujui'])->name('admin.setujui');
        Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
        Route::post('/pembayaran/{id}/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
        Route::get('/denah-booth', [AdminController::class, 'denahBooth'])->name('admin.denah');
        Route::get('/event', [AdminController::class, 'event'])->name('admin.event');
        Route::post('/event', [AdminController::class, 'eventStore'])->name('admin.event.store');
        Route::get('/tenant', [AdminController::class, 'dataTenant'])->name('admin.tenant');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');
        Route::get('/laporan/csv', [AdminController::class, 'laporanCsv'])->name('admin.laporan.csv');
        Route::get('/log', [AdminController::class, 'logAktivitas'])->name('admin.log');
    });
});

require __DIR__.'/auth.php';