@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>{{ $category->name }}</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label text-muted">Nama Kategori</label>
            <p class="mb-0"><strong>{{ $category->name }}</strong></p>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Deskripsi</label>
            <p class="mb-0">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Jumlah Barang</label>
            <p class="mb-0"><span class="badge bg-info">{{ $category->items()->count() }}</span></p>
        </div>
    </div>
</div>
@endsection
