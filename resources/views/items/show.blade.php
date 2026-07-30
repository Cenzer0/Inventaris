@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>{{ $item->name }}</h1>
        <small class="text-muted">Kode: <code>{{ $item->simda_code }}</code></small>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('items.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Barang</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Kode SIMDA</label>
                    <p class="mb-0"><code>{{ $item->simda_code }}</code></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Nama</label>
                    <p class="mb-0"><strong>{{ $item->name }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Deskripsi</label>
                    <p class="mb-0">{{ $item->description ?? 'Tidak ada deskripsi' }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Kategori</label>
                    <p class="mb-0"><span class="badge bg-info">{{ $item->category->name }}</span></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Tipe Barang</label>
                    <p class="mb-0">
                        @if($item->item_type === 'Elektronik')
                            <span class="badge bg-primary"><i class="fas fa-plug"></i> Elektronik</span>
                        @elseif($item->item_type === 'Kendaraan')
                            <span class="badge bg-secondary"><i class="fas fa-car"></i> Kendaraan</span>
                        @elseif($item->item_type === 'Mebeler')
                            <span class="badge bg-warning text-dark"><i class="fas fa-chair"></i> Mebeler</span>
                        @else
                            <span class="badge bg-light text-dark"><i class="fas fa-box"></i> Umum</span>
                        @endif
                    </p>
                </div>
                @if($item->purchase_date)
                <div class="mb-3">
                    <label class="form-label text-muted">Tanggal Pembelian</label>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($item->purchase_date)->format('d/m/Y') }} 
                        <small class="text-muted">({{ \Carbon\Carbon::parse($item->purchase_date)->diffForHumans() }})</small>
                    </p>
                </div>
                @endif
                @if($item->item_type === 'Kendaraan' && $item->last_service_date)
                <div class="mb-3">
                    <label class="form-label text-muted">Tanggal Servis Terakhir</label>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($item->last_service_date)->format('d/m/Y') }}
                        <small class="text-muted">({{ \Carbon\Carbon::parse($item->last_service_date)->diffForHumans() }})</small>
                    </p>
                </div>
                @endif
                <div class="mb-3">
                    <label class="form-label text-muted">Satuan</label>
                    <p class="mb-0">{{ $item->unit->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Stok & Harga</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">Harga Satuan</label>
                    <p class="mb-0"><strong>Rp {{ number_format($item->unit_price, 0, ',', '.') }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Stok Saat Ini</label>
                    <p class="mb-0">
                        @if($item->stock < 5)
                            <span class="badge bg-danger" style="font-size: 1.2em;">{{ $item->stock }} {{ $item->unit->name }}</span>
                        @elseif($item->stock < 10)
                            <span class="badge bg-warning" style="font-size: 1.2em;">{{ $item->stock }} {{ $item->unit->name }}</span>
                        @else
                            <span class="badge bg-success" style="font-size: 1.2em;">{{ $item->stock }} {{ $item->unit->name }}</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Nilai Total Inventaris</label>
                    <p class="mb-0"><strong>Rp {{ number_format($item->stock * $item->unit_price, 0, ',', '.') }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Tanggal Dibuat</label>
                    <p class="mb-0">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="mb-0 text-dark fw-bold"><i class="fas fa-list-alt me-2 text-primary"></i>Detail Inventaris Lengkap</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Kategori Aset</label>
                        <p class="mb-0 fw-medium">{{ $item->asset_category ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor Urut Pendaftaran</label>
                        <p class="mb-0 fw-medium">{{ $item->registration_number ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor Register</label>
                        <p class="mb-0 fw-medium">{{ $item->register_number ?? '-' }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Merk/Type</label>
                        <p class="mb-0 fw-medium">{{ $item->brand_type ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Ukuran/CC</label>
                        <p class="mb-0 fw-medium">{{ $item->size_spec ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Bahan</label>
                        <p class="mb-0 fw-medium">{{ $item->material ?? '-' }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor Pabrik</label>
                        <p class="mb-0 fw-medium">{{ $item->factory_number ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor Rangka</label>
                        <p class="mb-0 fw-medium">{{ $item->chassis_number ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor Mesin</label>
                        <p class="mb-0 fw-medium">{{ $item->engine_number ?? '-' }}</p>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor Polisi</label>
                        <p class="mb-0 fw-medium">{{ $item->license_plate ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Nomor BPKB</label>
                        <p class="mb-0 fw-medium">{{ $item->bpkb_number ?? '-' }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-muted small mb-1">Asal Usul</label>
                        <p class="mb-0 fw-medium">{{ $item->acquisition_source ?? '-' }}</p>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label text-muted small mb-1">Ruang/Lokasi</label>
                        <p class="mb-0 fw-medium">{{ $item->location ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($item->isDepreciable())
<div class="row text-dark">
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-calculator me-2"></i>Analisis Penyusutan Nilai Aset (Metode Garis Lurus)</h5>
            </div>
            <div class="card-body">
                @php
                    $dep = $item->calculateDepreciation();
                @endphp
                @if($dep['depreciable'])
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted small mb-1">Masa Manfaat</label>
                            <p class="mb-0">
                                <strong>{{ $item->useful_life ?? $item->getStandardUsefulLife() }} Tahun</strong> 
                                <span class="text-muted small">({{ ($item->useful_life ?? $item->getStandardUsefulLife()) * 12 }} Bulan)</span>
                                @if(empty($item->useful_life))
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 ms-1" style="font-size:0.6rem">Standar</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted small mb-1">Nilai Residu</label>
                            <p class="mb-0"><strong>Rp {{ number_format($item->residual_value, 0, ',', '.') }}</strong></p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-muted small mb-1">Umur Ekonomis Berjalan</label>
                            <p class="mb-0">
                                <strong>{{ $dep['months_elapsed'] }} Bulan</strong>
                                @if($dep['is_fully_depreciated'])
                                    <span class="badge bg-danger ms-1">Masa Manfaat Habis</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr class="opacity-5 my-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-semibold text-muted mb-3"><i class="fas fa-box me-1"></i>Nilai per Unit Barang</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted ps-0">Harga Perolehan:</td>
                                    <td class="text-end fw-medium">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Penyusutan per Bulan:</td>
                                    <td class="text-end text-danger fw-medium">-Rp {{ number_format($dep['monthly_depreciation'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Penyusutan per Tahun:</td>
                                    <td class="text-end text-danger fw-medium">-Rp {{ number_format($dep['annual_depreciation'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0 fw-bold border-top">Akumulasi Penyusutan:</td>
                                    <td class="text-end text-danger fw-bold border-top">-Rp {{ number_format($dep['accumulated_depreciation'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0 fw-bold border-top text-success">Nilai Aset Saat Ini:</td>
                                    <td class="text-end text-success fw-bold border-top">Rp {{ number_format($dep['book_value'], 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-semibold text-muted mb-3"><i class="fas fa-boxes me-1"></i>Nilai Total Inventaris (Stok: {{ $item->stock }} {{ $item->unit->name }})</h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted ps-0">Total Nilai Perolehan:</td>
                                    <td class="text-end fw-medium">Rp {{ number_format($item->unit_price * $item->stock, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Total Penyusutan/Bulan:</td>
                                    <td class="text-end text-danger fw-medium">-Rp {{ number_format($dep['monthly_depreciation'] * $item->stock, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0">Total Penyusutan/Tahun:</td>
                                    <td class="text-end text-danger fw-medium">-Rp {{ number_format($dep['annual_depreciation'] * $item->stock, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0 fw-bold border-top">Total Akumulasi Penyusutan:</td>
                                    <td class="text-end text-danger fw-bold border-top">-Rp {{ number_format($dep['accumulated_depreciation'] * $item->stock, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0 fw-bold border-top text-success">Total Nilai Aset Saat Ini:</td>
                                    <td class="text-end text-success fw-bold border-top">Rp {{ number_format($dep['book_value'] * $item->stock, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning d-flex align-items-center mb-0" role="alert" style="border-radius: 10px;">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <strong>Informasi belum lengkap:</strong> Harap lengkapi <strong>Tanggal Pembelian</strong> dengan mengedit barang ini agar sistem dapat menghitung data penyusutan aset secara otomatis.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Transaksi</h5>
                    <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Catat Transaksi
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $trans)
                                    <tr>
                                        <td>{{ $trans->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($trans->type === 'in')
                                                <span class="badge bg-success">Masuk</span>
                                            @else
                                                <span class="badge bg-danger">Keluar</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $trans->quantity }}</strong></td>
                                        <td>{{ $trans->user->name ?? '-' }}</td>
                                        <td>{{ $trans->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center p-3">
                        {{ $transactions->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="alert alert-info m-3 mb-3">
                        Belum ada transaksi untuk barang ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
