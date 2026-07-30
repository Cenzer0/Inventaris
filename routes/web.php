<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\DocumentArchiveController;
use App\Http\Controllers\RekapPersediaanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route untuk autentikasi (login, register, logout, dll.)
Auth::routes();

// Route untuk mengarahkan '/home' ke dashboard
Route::any('/home', function () {
    return redirect('/', 303);
});

// Grup route yang HARUS melalui autentikasi (login) terlebih dahulu
Route::middleware('auth')->group(function () {
    // Route Dashboard (Halaman Utama) - Semua role bisa akses
    Route::match(['get', 'post'], '/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/realtime', [DashboardController::class, 'realtimeData'])->name('dashboard.realtime');

    // Reports
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/depreciation', [ReportController::class, 'depreciation'])->name('reports.depreciation');
    
    // Rekap Persediaan (SIMDA)
    Route::get('/rekap-persediaan', [RekapPersediaanController::class, 'index'])->name('rekap.index');

    // Route Notifikasi
    Route::get('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $url = $notification->data['url'] ?? null;

        // If the URL is relative, make sure it starts with /
        if ($url && !str_starts_with($url, '/') && !str_starts_with($url, 'http')) {
            $url = '/' . $url;
        }

        return redirect($url ?: route('dashboard'));
    })->name('notifications.read');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    })->name('notifications.markAllRead');

    // Transaksi Laporan - Semua role (terutama pimpinan) bisa akses
    Route::get('transactions/report/monthly', [RekapPersediaanController::class, 'index'])->name('transactions.report');
    Route::get('transactions/report/pdf', [InventoryTransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    Route::get('transactions/report/excel', [InventoryTransactionController::class, 'exportExcel'])->name('transactions.export.excel');
    
    // Export Rekap Persediaan Bulanan
    Route::get('rekap-persediaan/pdf', [RekapPersediaanController::class, 'exportPdf'])->name('rekap.export.pdf');
    Route::get('rekap-persediaan/excel', [RekapPersediaanController::class, 'exportExcel'])->name('rekap.export.excel');

    // Penyusutan Aset
    Route::get('depreciations', [\App\Http\Controllers\DepreciationController::class, 'index'])->name('depreciations.index');

    // Grup route yang HARUS memiliki akses admin_gudang untuk manipulasi data
    Route::middleware('role:admin_gudang')->group(function () {
        // --- Route untuk Master Data ---
        // Kategori (CRUD)
        Route::resource('categories', CategoryController::class);
        
        // Satuan (CRUD)
        Route::resource('units', UnitController::class);
        
        // Barang/Item (CRUD)
        Route::resource('items', ItemController::class);
        
        // Transaksi Inventaris (Selain laporan)
        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [InventoryTransactionController::class, 'index'])->name('index');
            Route::get('/create', [InventoryTransactionController::class, 'create'])->name('create');
            Route::post('/', [InventoryTransactionController::class, 'store'])->name('store');
            Route::get('/{transaction}', [InventoryTransactionController::class, 'show'])->name('show');
            Route::delete('/{transaction}', [InventoryTransactionController::class, 'destroy'])->name('destroy');
        });

        // Arsip Dokumen Hukum - CRUD (tambah, edit, hapus) hanya superadmin & admin_gudang
        Route::get('archives/create', [DocumentArchiveController::class, 'create'])->name('archives.create');
        Route::post('archives', [DocumentArchiveController::class, 'store'])->name('archives.store');
        Route::get('archives/{archive}/edit', [DocumentArchiveController::class, 'edit'])->name('archives.edit');
        Route::put('archives/{archive}', [DocumentArchiveController::class, 'update'])->name('archives.update');
        Route::delete('archives/{archive}', [DocumentArchiveController::class, 'destroy'])->name('archives.destroy');
    });

    // Arsip Dokumen Hukum - Semua role bisa melihat, download, dan preview
    Route::get('archives', [DocumentArchiveController::class, 'index'])->name('archives.index');
    Route::get('archives/{archive}', [DocumentArchiveController::class, 'show'])->name('archives.show');
    Route::get('archives/{archive}/download', [DocumentArchiveController::class, 'download'])->name('archives.download');
    Route::get('archives/{archive}/preview', [DocumentArchiveController::class, 'preview'])->name('archives.preview');

    // Grup route KHUSUS Superadmin
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});

