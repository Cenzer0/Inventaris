@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('users.index') }}" class="btn btn-light rounded-circle me-3 border shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <svg class="" style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
</svg>
            </a>
            <h4 class="mb-0 fw-bold">Edit Pengguna</h4>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold text-muted small text-uppercase">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 px-4 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

</svg>
            </a>
            <h4 class="mb-0 fw-bold">Edit Pengguna</h4>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold text-muted small text-uppercase">Nama Lengkap</label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 px-4 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold text-muted small text-uppercase">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 border-end-0 px-4"><svg class="text-muted" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
</svg></span>
                            <input type="text" class="form-control form-control-lg bg-light border-0 border-start-0 px-0 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                        </div>
                        @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-12 mb-2">
                            <div class="alert alert-info border-0 rounded-3 small py-2"><svg class="me-2" style="width:16px;height:16px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
</svg> Kosongkan password jika tidak ingin mengubahnya.</div>
                        </div>
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="password" class="form-label fw-semibold text-muted small text-uppercase">Password Baru (Opsional)</label>
                            <input type="password" class="form-control form-control-lg bg-light border-0 px-4 @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold text-muted small text-uppercase">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control form-control-lg bg-light border-0 px-4" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="role" class="form-label fw-semibold text-muted small text-uppercase">Hak Akses / Peran</label>
                        <select class="form-select form-select-lg bg-light border-0 px-4 @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh)</option>
                            <option value="admin_gudang" {{ old('role', $user->role) == 'admin_gudang' ? 'selected' : '' }}>Admin Gudang (Kelola Data & Transaksi)</option>
                            <option value="pimpinan" {{ old('role', $user->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan (Hanya Laporan)</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('users.index') }}" class="btn btn-light btn-lg px-4 me-md-2" style="border-radius: 12px;">Batal</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" style="border-radius: 12px;">
                            <svg class="me-2" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
</svg> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
