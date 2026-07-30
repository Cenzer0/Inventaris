@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Welcome Banner (Hero Section) -->
<div class="row mb-5">
    <div class="col-12">
        <div class="hero-banner shadow-lg">
            <div class="hero-shape-1"></div>
            <div class="hero-shape-2"></div>
            <div class="hero-shape-3"></div>
            
            <div class="card-body p-4 p-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between" style="position: relative; z-index: 1;">
                <div class="text-center text-md-start mb-4 mb-md-0">
                    <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-2 mb-3 border border-white border-opacity-10 backdrop-blur" style="backdrop-filter: blur(10px);">
                        Sistem Informasi Inventaris
                    </span>
                    <span id="realtime-indicator" class="badge rounded-pill px-3 py-2 mb-3 ms-2 border border-white border-opacity-10" style="backdrop-filter: blur(10px); background: rgba(16,185,129,0.3); color: #fff;">
                        <span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px; animation: pulse-dot 1.5s infinite;"></span>
                        Live
                    </span>
                    <h1 class="mb-2 fw-bolder text-white" style="font-size: 2.75rem; letter-spacing: -1px;">
                        Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }} 👋
                    </h1>
                    <p class="text-white-50 mb-0" style="font-size: 1.15rem; font-weight: 300;">Kelola aset dan inventaris Bagian Hukum Kota Tegal dengan mudah.</p>
                </div>
                <div class="d-none d-md-block text-end">
                    <div class="glass-panel p-4 rounded-4 text-center">
                        <div class="text-uppercase fw-bold text-white-50 mb-1" style="font-size: 0.75rem; letter-spacing: 2px;">Tanggal Hari Ini</div>
                        <div class="fw-bold fs-4 text-white">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                        <div class="text-white-50 small mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Utama -->
<div class="row mb-5 g-4">
    <div class="col-md-3">
        <div class="card stat-card border-0 h-100 p-2 text-dark" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
</svg>
                    </div>
                    <span class="badge bg-light text-muted rounded-pill border">Total</span>
                </div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Total Jenis Barang</h6>
                    <h2 id="stat-totalItems" class="fw-bolder mb-0 fs-1 text-dark">{{ number_format($totalItems, 0, ',', '.') }}</h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress rounded-pill bg-light" style="height: 6px;">
                    <div class="progress-bar bg-primary rounded-pill progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card border-0 h-100 p-2 text-dark" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-success bg-opacity-10 text-success">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/>
</svg>
                    </div>
                    <span class="badge bg-light text-muted rounded-pill border">Stok</span>
                </div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Total Item Fisik</h6>
                    <h2 id="stat-totalStock" class="fw-bolder mb-0 fs-1 text-dark">{{ number_format($totalStock, 0, ',', '.') }}</h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress rounded-pill bg-light" style="height: 6px;">
                    <div class="progress-bar bg-success rounded-pill progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card border-0 h-100 p-2 text-dark" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-warning bg-opacity-10 text-warning">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
</svg>
                    </div>
                    <span class="badge" style="background-color: #fef3c7; color: #d97706;">Perhatian</span>
                </div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Stok Menipis</h6>
                    <h2 id="stat-lowStockItems" class="fw-bolder mb-0 fs-1 text-dark">{{ number_format($lowStockItems, 0, ',', '.') }}</h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress rounded-pill bg-light" style="height: 6px;">
                    <div class="progress-bar bg-warning rounded-pill" style="width: {{ $totalItems > 0 ? min(100, ($lowStockItems / $totalItems) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card border-0 h-100 p-2 text-dark" style="background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-box bg-indigo bg-opacity-10 text-indigo" style="color: #4f46e5;">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z"/>
</svg>
                    </div>
                    <span class="badge bg-light text-muted rounded-pill border">Aset</span>
                </div>
                <div>
                    <h6 class="text-muted fw-semibold mb-1" style="font-size: 0.9rem;">Total Nilai Inventaris</h6>
                    <h3 id="stat-totalInventoryValue" class="fw-bolder mb-0 text-dark" style="font-size: 1.4rem; letter-spacing: -0.5px;">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <div class="progress rounded-pill bg-light" style="height: 6px;">
                    <div class="progress-bar rounded-pill" style="background-color: #4f46e5; width: 100%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Bulan Ini (Highlight Strip) -->
<div class="card border-0 shadow-sm mb-5 hover-lift-subtle" style="border-radius: 20px; background: #fff;">
    <div class="card-body p-1">
        <div class="row g-0 text-center">
            <div class="col-md-4 p-4 border-end-md position-relative">
                <div class="text-success mb-2 d-flex justify-content-center align-items-center">
                    <svg class="me-2" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>
                    <span class="fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Barang Masuk (Bulan Ini)</span>
                </div>
                <h3 class="fw-bolder mb-0 text-dark"><span id="stat-monthlyIncoming">{{ number_format($monthlyIncoming, 0, ',', '.') }}</span> <span class="text-muted fs-6 fw-normal text-lowercase">item</span></h3>
            </div>
            <div class="col-md-4 p-4 border-end-md position-relative">
                <div class="text-danger mb-2 d-flex justify-content-center align-items-center">
                    <svg class="me-2" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>
                    <span class="fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Barang Keluar (Bulan Ini)</span>
                </div>
                <h3 class="fw-bolder mb-0 text-dark"><span id="stat-monthlyOutgoing">{{ number_format($monthlyOutgoing, 0, ',', '.') }}</span> <span class="text-muted fs-6 fw-normal text-lowercase">item</span></h3>
            </div>
            <div class="col-md-4 p-4 position-relative">
                <div class="text-primary mb-2 d-flex justify-content-center align-items-center">
                    <svg class="me-2" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
</svg>
                    <span class="fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Total Transaksi (Bulan Ini)</span>
                </div>
                <h3 class="fw-bolder mb-0 text-dark"><span id="stat-monthlyTransactions">{{ number_format($monthlyTransactions, 0, ',', '.') }}</span> <span class="text-muted fs-6 fw-normal text-lowercase">aktivitas</span></h3>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mb-5 g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Arus Transaksi</h5>
                    <p class="text-muted small mb-0">Statistik barang masuk dan keluar 6 bulan terakhir</p>
                </div>
                <div class="icon-box bg-light text-muted" style="width: 40px; height: 40px;">
                    <svg class="" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
</svg>
                </div>
            </div>
            <div class="card-body bg-white px-4 pb-4 pt-2">
                <div id="transactionChart" style="min-height: 350px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Distribusi Kategori</h5>
                    <p class="text-muted small mb-0">Persentase jumlah barang per kategori</p>
                </div>
                <div class="icon-box bg-light text-muted" style="width: 40px; height: 40px;">
                    <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/>
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/>
</svg>
                </div>
            </div>
            <div class="card-body bg-white px-4 pb-4 pt-4 d-flex align-items-center justify-content-center">
                <div id="categoryChart" class="w-100" style="min-height: 320px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Barang Stok Rendah -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white" style="border-radius: 20px;">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3">
                        <svg class="text-warning" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"/>
</svg>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark">Stok Menipis</h5>
                </div>
                @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_gudang']))
                <a href="{{ route('items.index') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-medium transition-hover">Lihat Semua</a>
                @endif
            </div>
            <div class="card-body px-4 pt-0 pb-4">
                @if($lowStockItemsList->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($lowStockItemsList->take(4) as $item)
                        <div class="list-group-item border-0 py-2 px-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center text-truncate pe-3">
                                <span class="bg-light text-warning rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 28px; height: 28px;">
                                    <i class="fas fa-exclamation-circle" style="font-size: 12px;"></i>
                                </span>
                                <span class="fw-semibold text-dark text-truncate" style="font-size: 0.85rem;" title="{{ $item->name }}">{{ $item->name }}</span>
                            </div>
                            <span class="badge bg-danger rounded-pill px-2 py-1 flex-shrink-0" style="font-size: 0.7rem;">
                                {{ $item->stock }} {{ $item->unit->name ?? 'unit' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 py-3 text-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle mb-2">
                            <i class="fas fa-check text-success"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">Stok Aman</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100 bg-white" style="border-radius: 20px;">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-2 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-indigo bg-opacity-10 p-2 rounded-circle me-3" style="color: #4f46e5;">
                        <svg class="" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark">Transaksi Terbaru</h5>
                </div>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-medium transition-hover">Histori</a>
            </div>
            <div class="card-body px-4 pt-0 pb-4">
                @if($recentTransactions->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentTransactions->take(4) as $trans)
                        <div class="list-group-item border-0 py-2 px-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center text-truncate pe-3">
                                <span class="bg-{{ $trans->type == 'in' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $trans->type == 'in' ? 'success' : 'danger' }} rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 28px; height: 28px;">
                                    <i class="fas fa-arrow-{{ $trans->type == 'in' ? 'down' : 'up' }}" style="font-size: 11px;"></i>
                                </span>
                                <span class="fw-semibold text-dark text-truncate" style="font-size: 0.85rem;" title="{{ $trans->item->name }}">{{ $trans->item->name }}</span>
                            </div>
                            <div class="d-flex align-items-center flex-shrink-0">
                                <span class="text-muted me-2" style="font-size: 0.75rem;">{{ explode(' ', $trans->user->name ?? 'Sistem')[0] }}</span>
                                <span class="fw-bold text-{{ $trans->type == 'in' ? 'success' : 'danger' }}" style="font-size: 0.85rem;">
                                    {{ $trans->type == 'in' ? '+' : '-' }}{{ $trans->quantity }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 py-3 text-center">
                        <div class="bg-light p-2 rounded-circle mb-2">
                            <i class="fas fa-history text-muted"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">Belum Ada Histori</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-lg mb-5" style="border-radius: 20px; overflow: hidden; background: linear-gradient(120deg, #ffffff 0%, #f8fafc 100%);">
    <div class="card-body p-4 p-md-5">
        <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-4">
            <h5 class="fw-bold text-dark mb-0">
                Langkah Cepat
            </h5>
            <div class="ms-2 badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small">Aksi</div>
        </div>
        <div class="row g-3">
            @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_gudang']))
            <div class="col-6 col-md-auto flex-fill">
                <a href="{{ route('items.create') }}" class="btn-quick-action bg-white border border-light">
                    <div class="qa-icon-wrapper bg-primary bg-opacity-10 text-primary mb-3">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>
                    </div>
                    <span class="qa-text">Tambah Barang</span>
                </a>
            </div>
            <div class="col-6 col-md-auto flex-fill">
                <a href="{{ route('transactions.create') }}" class="btn-quick-action bg-white border border-light">
                    <div class="qa-icon-wrapper bg-success bg-opacity-10 text-success mb-3">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
</svg>
                    </div>
                    <span class="qa-text">Catat Transaksi</span>
                </a>
            </div>
            @endif
            <div class="col-6 col-md-auto flex-fill">
                <a href="{{ route('transactions.report') }}" class="btn-quick-action bg-white border border-light">
                    <div class="qa-icon-wrapper bg-info bg-opacity-10 text-info mb-3">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
</svg>
                    </div>
                    <span class="qa-text">Cetak Laporan</span>
                </a>
            </div>
            @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_gudang']))
            <div class="col-6 col-md-auto flex-fill">
                <a href="{{ route('items.index') }}" class="btn-quick-action bg-white border border-light">
                    <div class="qa-icon-wrapper bg-secondary bg-opacity-10 text-secondary mb-3">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
</svg>
                    </div>
                    <span class="qa-text">Daftar Barang</span>
                </a>
            </div>
            @endif
            @if(auth()->check() && auth()->user()->role === 'superadmin')
            <div class="col-6 col-md-auto flex-fill">
                <a href="{{ route('users.index') }}" class="btn-quick-action bg-white border border-light">
                    <div class="qa-icon-wrapper bg-warning bg-opacity-10 text-warning mb-3">
                        <svg class="" style="width: 24px; height: 24px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
</svg>
                    </div>
                    <span class="qa-text">Kelola User</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Hero Banner Styles */
    .hero-banner {
        background: linear-gradient(135deg, #0a254d 0%, #0f3b73 100%);
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        min-height: 220px;
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15) !important;
    }
    .hero-shape-1 {
        position: absolute;
        top: -150px;
        right: -100px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(196,140,44,0.25) 0%, rgba(196,140,44,0) 70%);
        border-radius: 50%;
        filter: blur(50px);
        animation: abstractPulse 12s infinite alternate ease-in-out;
    }
    .hero-shape-2 {
        position: absolute;
        bottom: -200px;
        left: -50px;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
        filter: blur(60px);
        animation: abstractPulse 15s infinite alternate-reverse ease-in-out;
    }
    .hero-shape-3 {
        position: absolute;
        top: 10%;
        left: 30%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, rgba(139,92,246,0) 70%);
        border-radius: 50%;
        filter: blur(50px);
    }
    
    @keyframes abstractPulse {
        0% { transform: scale(1) translate(0, 0); opacity: 0.8; }
        100% { transform: scale(1.1) translate(20px, -20px); opacity: 1; }
    }

    .glass-panel {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    /* Stat Cards */
    .stat-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08) !important;
    }
    .icon-box {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        transition: transform 0.4s ease;
    }
    .stat-card:hover .icon-box {
        transform: scale(1.1) rotate(-5deg);
    }

    /* Table Styles */
    .table-custom {
        border-collapse: separate;
        border-spacing: 0 10px;
    }
    .table-custom tr {
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.2s ease;
    }
    .table-custom tr:hover {
        transform: translateY(-2px) scale(1.01);
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        background: #fff;
    }
    .table-custom td {
        border: none;
        padding: 16px;
    }
    .table-custom td:first-child {
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }
    .table-custom td:last-child {
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    /* General Utilities */
    .border-end-md {
        border-right: 1px dashed #e2e8f0;
    }
    @media (max-width: 768px) {
        .border-end-md {
            border-right: none;
            border-bottom: 1px dashed #e2e8f0;
        }
    }

    .transition-hover {
        transition: all 0.2s ease;
    }
    .hover-bg-white:hover {
        background-color: #fff !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: #e2e8f0 !important;
    }
    .hover-lift-subtle {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-lift-subtle:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.06) !important;
    }

    /* Quick Actions */
    .btn-quick-action {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
        border-radius: 20px;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .btn-quick-action:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        color: #0f172a;
    }
    .qa-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-quick-action:hover .qa-icon-wrapper {
        transform: scale(1.15) translateY(-5px);
    }
    .qa-text {
        font-weight: 600;
        font-size: 0.95rem;
    }
</style>

<!-- ApexCharts Script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(typeof ApexCharts === 'undefined') return;

        // ===== AREA CHART: Tren Transaksi =====
        var transactionOptions = {
            series: [{
                name: 'Barang Masuk',
                data: {!! json_encode($chartIncoming) !!}
            }, {
                name: 'Barang Keluar',
                data: {!! json_encode($chartOutgoing) !!}
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, system-ui, sans-serif',
                animations: { enabled: true, easing: 'easeinout', speed: 800, dynamicAnimation: { enabled: true, speed: 500 } }
            },
            colors: ['#10b981', '#ef4444'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: {!! json_encode($chartMonths) !!},
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#64748b', fontWeight: 500 } }
            },
            yaxis: { labels: { style: { colors: '#64748b', fontWeight: 500 } } },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            tooltip: { theme: 'light' },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
            },
            legend: { position: 'top', horizontalAlign: 'right', markers: { radius: 12 }, itemMargin: { horizontal: 10 } }
        };
        var transactionChart = new ApexCharts(document.querySelector('#transactionChart'), transactionOptions);
        transactionChart.render();

        // ===== DONUT CHART: Kategori =====
        var categoryOptions = {
            series: {!! json_encode($categoryData) !!},
            chart: {
                height: 320,
                type: 'donut',
                fontFamily: 'Inter, system-ui, sans-serif',
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            labels: {!! json_encode($categoryLabels) !!},
            colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            name: { show: true, color: '#64748b', fontSize: '14px', fontWeight: 500 },
                            value: { show: true, color: '#0f172a', fontSize: '24px', fontWeight: 700 },
                            total: { show: true, showAlways: true, label: 'Total', color: '#64748b' }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: false },
            legend: { position: 'bottom', markers: { radius: 12 }, itemMargin: { horizontal: 10, vertical: 5 } },
            tooltip: { theme: 'light' }
        };
        var categoryChart = new ApexCharts(document.querySelector('#categoryChart'), categoryOptions);
        categoryChart.render();

        // ===== REALTIME DATA POLLING (every 10 seconds) =====
        var POLL_URL = '{{ route("dashboard.realtime") }}';
        var POLL_INTERVAL = 10000; // 10 seconds

        function flashUpdate(el) {
            if (!el) return;
            el.style.transition = 'background-color 0.3s ease';
            el.style.backgroundColor = 'rgba(16,185,129,0.15)';
            el.style.borderRadius = '8px';
            setTimeout(function() { el.style.backgroundColor = 'transparent'; }, 1200);
        }

        function updateStats(stats) {
            var map = {
                'stat-totalItems': stats.totalItems,
                'stat-totalStock': stats.totalStock,
                'stat-lowStockItems': stats.lowStockItems,
                'stat-monthlyIncoming': stats.monthlyIncoming,
                'stat-monthlyOutgoing': stats.monthlyOutgoing,
                'stat-monthlyTransactions': stats.monthlyTransactions
            };
            for (var id in map) {
                var el = document.getElementById(id);
                if (el && el.textContent.trim() !== map[id]) {
                    el.textContent = map[id];
                    flashUpdate(el);
                }
            }
            var valEl = document.getElementById('stat-totalInventoryValue');
            if (valEl) {
                var newVal = 'Rp ' + stats.totalInventoryValue;
                if (valEl.textContent.trim() !== newVal) {
                    valEl.textContent = newVal;
                    flashUpdate(valEl);
                }
            }
        }

        function fetchRealtimeData() {
            var indicator = document.getElementById('realtime-indicator');
            fetch(POLL_URL, { credentials: 'same-origin' })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    // Update stats
                    updateStats(data.stats);

                    // Update Area Chart
                    transactionChart.updateOptions({
                        xaxis: { categories: data.chart.months }
                    }, false, false);
                    transactionChart.updateSeries([
                        { name: 'Barang Masuk', data: data.chart.incoming },
                        { name: 'Barang Keluar', data: data.chart.outgoing }
                    ]);

                    // Update Donut Chart
                    categoryChart.updateOptions({ labels: data.category.labels }, false, false);
                    categoryChart.updateSeries(data.category.data);

                    // Pulse the indicator green
                    if (indicator) {
                        indicator.style.background = 'rgba(16,185,129,0.3)';
                    }
                })
                .catch(function(err) {
                    console.warn('Realtime refresh failed:', err);
                    if (indicator) {
                        indicator.style.background = 'rgba(239,68,68,0.3)';
                    }
                });
        }

        // Start polling
        setInterval(fetchRealtimeData, POLL_INTERVAL);

        // Also fetch once after 2 seconds to show it's working
        setTimeout(fetchRealtimeData, 2000);
    });
</script>

<style>
    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.4; transform: scale(0.8); }
    }
</style>
@endsection
