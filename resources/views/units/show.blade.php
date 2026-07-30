@extends('layouts.app')

@section('title', 'Detail Satuan')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>{{ $unit->name }}</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('units.edit', $unit) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('units.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label text-muted">Nama Satuan</label>
            <p class="mb-0"><strong>{{ $unit->name }}</strong></p>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Jumlah Barang</label>
            <p class="mb-0"><span class="badge bg-info">{{ $unit->items()->count() }}</span></p>
        </div>
    </div>
</div>
@endsection
