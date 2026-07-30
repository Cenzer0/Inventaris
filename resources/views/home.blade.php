@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-7 col-lg-6">
        <div class="card shadow-lg border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-shield fa-3x text-primary mb-3"></i>
                <h2 class="mb-3">Selamat Datang di Sistem Inventaris Hukum</h2>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="lead">Anda berhasil login! Silakan gunakan menu di samping untuk mengelola data inventaris.</p>
            </div>
        </div>
    </div>
</div>
@endsection
