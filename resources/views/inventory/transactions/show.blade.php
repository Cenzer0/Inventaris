@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Detail Transaksi</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">ID Transaksi</label>
                    <p class="mb-0"><code>#{{ $transaction->id }}</code></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Tanggal</label>
                    <p class="mb-0">{{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Tipe</label>
                    <p class="mb-0">
                        @if($transaction->type === 'in')
                            <span class="badge bg-success" style="font-size: 1em;">📥 Barang Masuk</span>
                        @else
                            <span class="badge bg-danger" style="font-size: 1em;">📤 Barang Keluar</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">User</label>
                    <p class="mb-0">{{ $transaction->user->name ?? 'Sistem' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Barang</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Nama Barang</label>
                    <p class="mb-0">
                        <strong>{{ $transaction->item->name }}</strong><br>
                        <code>{{ $transaction->item->simda_code }}</code>
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Kategori</label>
                    <p class="mb-0"><span class="badge bg-info">{{ $transaction->item->category->name }}</span></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Jumlah</label>
                    <p class="mb-0">
                        <strong style="font-size: 1.5em;">{{ $transaction->quantity }}</strong> 
                        {{ $transaction->item->unit->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if($transaction->notes)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Keterangan</h5>
                </div>
                <div class="card-body">
                    <p>{{ $transaction->notes }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus Transaksi
            </button>
        </form>
    </div>
</div>
@endsection
