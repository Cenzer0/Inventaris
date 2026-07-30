<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris') - Bagian Hukum Kota Tegal</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bs-primary: #0f3b73;
            --bs-primary-rgb: 15, 59, 115;
            --bs-warning: #c48c2c;
            --bs-warning-rgb: 196, 140, 44;
        }
        .text-primary { color: #0f3b73 !important; }
        .bg-primary:not([class*="bg-opacity"]) { background-color: #0f3b73 !important; }
        .bg-primary.bg-opacity-10 { background-color: rgba(15, 59, 115, 0.1) !important; }
        .bg-primary.bg-opacity-20 { background-color: rgba(15, 59, 115, 0.2) !important; }
        .btn-primary { background-color: #0f3b73; border-color: #0f3b73; }
        .btn-primary:hover { background-color: #0a254d; border-color: #0a254d; }
        .btn-outline-primary { color: #0f3b73; border-color: #0f3b73; }
        .btn-outline-primary:hover { background-color: #0f3b73; border-color: #0f3b73; }
        .border-primary { border-color: #0f3b73 !important; }
        .text-warning { color: #c48c2c !important; }
        .bg-warning:not([class*="bg-opacity"]) { background-color: #c48c2c !important; }
        .bg-warning.bg-opacity-10 { background-color: rgba(196, 140, 44, 0.1) !important; }
        .bg-indigo, .bg-indigo.bg-opacity-10 { background-color: rgba(15, 59, 115, 0.1) !important; }
        .text-indigo { color: #0f3b73 !important; }
    </style>
</head>
<body style="background: #f8fafc; color: #1e293b; font-family: 'Inter', system-ui, -apple-system, sans-serif; min-height: 100vh;">
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <nav class="sidebar bg-white border-end d-flex flex-column px-3 py-4" style="width: 260px; min-height: 100vh; position: sticky; top: 0;">
            <div class="w-100 mb-4 px-2">
                <div class="d-flex flex-column align-items-center mb-2 text-center px-2">
                    <img src="{{ asset('images/logo_tegal.png') }}" alt="Logo Bagian Hukum Setda Kota Tegal" style="max-width: 100%; height: auto; max-height: 90px; object-fit: contain;">
                    <div class="mt-3 fw-bold text-primary" style="font-size: 0.9rem; line-height: 1.3; letter-spacing: 0.5px;">
                        BAGIAN HUKUM<br>SETDA KOTA TEGAL
                    </div>
                </div>
                <hr class="my-4 opacity-5">
            </div>

            <div class="flex-grow-1">
                <div class="text-uppercase text-muted fw-bold mb-3 px-2" style="font-size: 0.7rem; letter-spacing: 1px;">Menu Utama</div>
                <ul class="nav flex-column w-100">
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('dashboard') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
</svg> 
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @if(auth()->check() && auth()->user()->role === 'superadmin')
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('users.*') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('users.index') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
</svg> 
                            <span>Manajemen User</span>
                        </a>
                    </li>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'admin_gudang')
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('categories.*') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('categories.index') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
</svg> 
                            <span>Kategori</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('units.*') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('units.index') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/>
</svg> 
                            <span>Satuan</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('items.*') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('items.index') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
</svg> 
                            <span>Barang</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('transactions.*') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('transactions.index') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"/>
</svg> 
                            <span>Transaksi</span>
                        </a>
                    </li>
                    @endif

                    {{-- Menu Arsip Dokumen - Semua role bisa akses --}}
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('archives.*') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('archives.index') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
</svg> 
                            <span>Arsip Dokumen</span>
                        </a>
                    </li>
                </ul>

                <div class="text-uppercase text-muted fw-bold mt-5 mb-3 px-2" style="font-size: 0.7rem; letter-spacing: 1px;">Laporan & Analisis</div>
                <ul class="nav flex-column w-100">
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('transactions.report') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('transactions.report') }}" style="transition: all 0.2s;">
                            <svg class="me-3" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
</svg> 
                            <span>Laporan Bulanan</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center px-3 py-2 rounded-3 {{ request()->routeIs('depreciations.index') ? 'bg-primary text-white shadow-sm fw-bold' : 'text-muted' }}" href="{{ route('depreciations.index') }}" style="transition: all 0.2s;">
                            <i class="fas fa-calculator me-3" style="width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;"></i>
                            <span>Penyusutan Aset</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="mt-auto pt-4 border-top">
                @auth
                <div class="dropdown w-100">
                    <div class="d-flex align-items-center px-2 mb-3">
                        <div class="bg-indigo text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; font-weight: 600;">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <div class="fw-bold text-dark text-truncate small">{{ Auth::user()->name }}</div>
                            <div class="text-muted small text-truncate text-capitalize" style="font-size: 0.7rem;">
                                @if(Auth::user()->role === 'superadmin')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2">Superadmin</span>
                                @elseif(Auth::user()->role === 'admin_gudang')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-2">Admin Gudang</span>
                                @elseif(Auth::user()->role === 'pimpinan')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">Pimpinan</span>
                                @else
                                    {{ str_replace('_', ' ', Auth::user()->role) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="d-block w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 border-0 text-start px-3 py-2 rounded-3">
                            <svg class="me-2" style="width: 16px; height: 16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
</svg> Logout
                        </button>
                    </form>
                </div>
                @else
                <a class="btn btn-primary w-100 d-flex align-items-center justify-content-center py-2 shadow-sm rounded-3" href="{{ route('login') }}">
                    <svg class="me-2" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/>
</svg> <span>Login</span>
                </a>
                @endauth
            </div>
        </nav>
        <!-- End Sidebar -->

        <!-- Main Content -->
        <div class="flex-grow-1 d-flex flex-column bg-light bg-opacity-50" style="min-height: 100vh;">
            <header class="bg-white border-bottom py-2 px-md-4 d-flex justify-content-end align-items-center shadow-sm" style="position: relative; z-index: 1030;">
                @auth
                @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                    $recentNotifications = auth()->user()->unreadNotifications()->take(10)->get();
                @endphp
                <div class="dropdown" style="position: relative;">
                    <button class="btn btn-light position-relative border-0" type="button" id="notificationDropdown" aria-expanded="false" style="border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-bell text-muted" style="font-size: 1.2rem;"></i>
                        @if($unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu shadow border-0" aria-labelledby="notificationDropdown" style="position: absolute; right: 0; left: auto; top: 120%; width: 340px; max-height: 450px; overflow-y: auto; z-index: 9999; border-radius: 16px; margin-top: 10px; padding: 0; box-shadow: 0 10px 40px rgba(0,0,0,0.12) !important;">
                        <li>
                            <div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center bg-light" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">
                                    <i class="fas fa-bell text-primary me-2"></i>Notifikasi Baru
                                </span>
                                @if($unreadCount > 0)
                                    <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-white text-primary rounded-pill px-3 fw-semibold border shadow-sm transition-hover" style="font-size: 0.75rem; background: #fff;">Tandai Dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </li>
                        @forelse($recentNotifications as $notification)
                            <li>
                                <a class="dropdown-item d-flex align-items-start p-3 border-bottom text-wrap transition-hover" href="{{ route('notifications.read', $notification->id) }}" style="white-space: normal; background-color: #fff;">
                                    <div class="me-3 mt-1">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                            <i class="{{ $notification->data['icon'] ?? 'fas fa-info-circle text-primary' }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold text-dark mb-1" style="font-size: 0.85rem; line-height: 1.4;">{{ $notification->data['message'] ?? 'Ada pemberitahuan baru' }}</div>
                                        <div class="text-muted d-flex align-items-center" style="font-size: 0.75rem;">
                                            <i class="far fa-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li>
                                <div class="p-5 text-center">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-check-circle text-success opacity-75" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">Sudah Dibaca Semua</h6>
                                    <p class="text-muted small mb-0">Tidak ada notifikasi baru yang masuk.</p>
                                </div>
                            </li>
                        @endforelse
                        @if(count($recentNotifications) > 0)
                        <li>
                            <div class="py-2 text-center bg-light" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                                <span class="text-muted fw-medium" style="font-size: 0.7rem; letter-spacing: 0.5px;">MENAMPILKAN NOTIFIKASI TERKINI</span>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
                @endauth
            </header>

            <main class="container-fluid py-4 px-md-5 flex-grow-1">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center" role="alert" style="border-radius: 12px; border-left: 4px solid #10b981 !important;">
                        <svg class="me-3" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
</svg>
                        <div class="fw-medium">{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mb-4 d-flex align-items-center" role="alert" style="border-radius: 12px; border-left: 4px solid #ef4444 !important;">
                        <svg class="me-3" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
</svg>
                        <div class="fw-medium">{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @yield('content')
            </main>
            <footer class="bg-white text-center py-3 border-top mt-auto">
                <p class="mb-0 text-muted small">&copy; {{ date('Y') }} Bagian Hukum Kota Tegal. <span class="mx-2 opacity-25">|</span> Developed with <svg class="text-danger d-inline-block" style="width: 12px; height: 12px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
</svg></p>
            </footer>
        </div>
        <!-- End Main Content -->
    </div>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Script Tembusan agar Lonceng Notifikasi Pasti Berfungsi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var bellBtn = document.getElementById('notificationDropdown');
            if (bellBtn) {
                bellBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var menu = this.nextElementSibling;
                    if(menu.classList.contains('show')) {
                        menu.classList.remove('show');
                    } else {
                        // Tutup dropdown lain jika ada
                        document.querySelectorAll('.dropdown-menu.show').forEach(function(el){
                            el.classList.remove('show');
                        });
                        menu.classList.add('show');
                    }
                });
                
                // Tutup ketika diklik di luar area dropdown
                document.addEventListener('click', function(e) {
                    var menu = bellBtn.nextElementSibling;
                    if (menu && menu.classList.contains('show') && !bellBtn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>