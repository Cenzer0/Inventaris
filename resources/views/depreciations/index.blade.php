@extends('layouts.app')

@section('title', 'Penyusutan Aset')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <i class="fas fa-calculator text-primary me-2 flex-shrink-0" style="font-size: 1.5rem;"></i>
            Penyusutan Aset Inventaris
        </h4>
        <p class="text-muted small mb-0">Analisis nilai buku, masa manfaat, dan akumulasi penyusutan barang (Elektronik, Kendaraan, Mebeler)</p>
    </div>
</div>

{{-- Top Cards Summary --}}
<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm rounded-4 bg-white" style="transition: transform 0.2s;">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width:54px; height:54px;">
                    <i class="fas fa-wallet fa-lg"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1">Total Nilai Perolehan</h6>
                    <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPerolehan, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm rounded-4 bg-white" style="transition: transform 0.2s;">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width:54px; height:54px;">
                    <i class="fas fa-chart-line fa-lg"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1">Total Akumulasi Penyusutan</h6>
                    <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($totalPenyusutan, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm rounded-4 bg-white" style="transition: transform 0.2s;">
            <div class="card-body p-4 d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width:54px; height:54px;">
                    <i class="fas fa-book-open fa-lg"></i>
                </div>
                <div>
                    <h6 class="text-muted small mb-1">Total Nilai Aset Saat Ini</h6>
                    <h4 class="fw-bold text-dark mb-0">Rp {{ number_format($totalNilaiBuku, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('depreciations.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" style="border-radius:0 10px 10px 0" name="search" placeholder="Cari nama barang atau kode SIMDA..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <i class="fas fa-filter text-muted"></i>
                    </span>
                    <select class="form-select border-start-0" style="border-radius:0 10px 10px 0" name="type">
                        <option value="">Semua Tipe Penyusutan</option>
                        <option value="Elektronik" {{ request('type') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Kendaraan" {{ request('type') == 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                        <option value="Mebeler" {{ request('type') == 'Mebeler' ? 'selected' : '' }}>Mebeler</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; height:42px">
                    <i class="fas fa-search me-1"></i> Cari & Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        @if($items->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.875rem">
                <thead>
                    <tr style="background:#f8fafc">
                        <th class="text-muted fw-semibold px-4 py-3 border-0" style="font-size:0.75rem; letter-spacing:0.5px">KODE SIMDA</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem; letter-spacing:0.5px">NAMA BARANG / HARGA</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem; letter-spacing:0.5px">TIPE & UMUR</th>
                        <th class="text-muted fw-semibold py-3 border-0 text-center" style="font-size:0.75rem; letter-spacing:0.5px">MASA MANFAAT</th>
                        <th class="text-muted fw-semibold py-3 border-0 text-end" style="font-size:0.75rem; letter-spacing:0.5px">AKUMULASI PENYUSUTAN (TOTAL)</th>
                        <th class="text-muted fw-semibold py-3 border-0 text-end" style="font-size:0.75rem; letter-spacing:0.5px">NILAI ASET SAAT INI (TOTAL)</th>
                        <th class="text-muted fw-semibold px-4 py-3 border-0 text-end" style="font-size:0.75rem; letter-spacing:0.5px">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    @php
                        $dep = $item->calculateDepreciation();
                        $itemTotalPerolehan = $item->unit_price * $item->stock;
                    @endphp
                    <tr>
                        <td class="px-4 py-3">
                            <code class="bg-light rounded px-2 py-1" style="font-size:0.8rem">{{ $item->simda_code }}</code>
                        </td>
                        <td class="py-3">
                            <div class="fw-bold text-dark">{{ Str::limit($item->name, 40) }}</div>
                            <small class="text-muted">Unit: Rp {{ number_format($item->unit_price, 0, ',', '.') }} | Stok: {{ $item->stock }} {{ $item->unit->name }}</small>
                        </td>
                        <td class="py-3">
                            <div>
                                @if($item->item_type === 'Elektronik')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10"><i class="fas fa-plug me-1"></i>Elektronik</span>
                                @elseif($item->item_type === 'Kendaraan')
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10"><i class="fas fa-car me-1"></i>Kendaraan</span>
                                @elseif($item->item_type === 'Mebeler')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10"><i class="fas fa-chair me-1"></i>Mebeler</span>
                                @else
                                    <span class="badge bg-light text-dark"><i class="fas fa-box me-1"></i>Umum</span>
                                @endif
                            </div>
                            @if($item->purchase_date)
                                <small class="text-muted d-block mt-1">Dibeli: {{ $item->purchase_date->format('d/m/Y') }} ({{ $dep['months_elapsed'] }} bln berjalan)</small>
                            @else
                                <small class="text-danger d-block mt-1"><i class="fas fa-exclamation-circle me-1"></i>Tgl pembelian belum diset</small>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            @if($item->useful_life)
                                <span class="fw-semibold">{{ $item->useful_life }} Tahun</span>
                                <small class="text-muted d-block mb-1">({{ $item->useful_life * 12 }} bulan)</small>
                                <span class="badge bg-secondary" style="font-size:0.6rem">Manual</span>
                            @else
                                <span class="fw-semibold text-primary">{{ $item->getStandardUsefulLife() }} Tahun</span>
                                <small class="text-muted d-block mb-1">({{ $item->getStandardUsefulLife() * 12 }} bulan)</small>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25" style="font-size:0.6rem" title="Ditetapkan otomatis berdasarkan standar Pemda">Standar Otomatis</span>
                            @endif
                        </td>
                        <td class="py-3 text-end">
                            @if($dep['depreciable'])
                                <div class="fw-semibold text-danger">Rp {{ number_format($dep['accumulated_depreciation'] * $item->stock, 0, ',', '.') }}</div>
                                <small class="text-muted">Per Unit: Rp {{ number_format($dep['accumulated_depreciation'], 0, ',', '.') }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="py-3 text-end">
                            @if($dep['depreciable'])
                                <div class="fw-bold text-success">Rp {{ number_format($dep['book_value'] * $item->stock, 0, ',', '.') }}</div>
                                <small class="text-muted">Per Unit: Rp {{ number_format($dep['book_value'], 0, ',', '.') }}</small>
                            @else
                                <div class="fw-bold text-success">Rp {{ number_format($itemTotalPerolehan, 0, ',', '.') }}</div>
                                <small class="text-muted">Per Unit: Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-light rounded-2 me-1" title="Lihat detail penyusutan" style="width:34px; height:34px; display:inline-flex; align-items:center; justify-content:center">
                                <i class="fas fa-eye text-info"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 d-flex justify-content-center">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-calculator text-muted opacity-25 mb-3" style="font-size: 3rem;"></i>
            <p class="text-muted mb-3">Tidak ada barang dengan tipe penyusutan yang terdaftar.</p>
        </div>
        @endif
    </div>
</div>
@endsection
