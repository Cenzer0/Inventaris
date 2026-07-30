@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
            Daftar Barang
        </h4>
        <p class="text-muted small mb-0">Kelola data barang dan inventaris</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('items.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
            <svg class="me-1" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Tambah Barang
        </a>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('items.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <svg style="width:16px;height:16px" class="text-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    </span>
                    <input type="text" class="form-control border-start-0" style="border-radius:0 10px 10px 0" name="search" placeholder="Cari barang atau kode..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <svg style="width:16px;height:16px" class="text-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
                    </span>
                    <select class="form-select border-start-0" style="border-radius:0 10px 10px 0" name="category" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        
                        <option value="tetap" class="fw-bold" {{ request('category') == 'tetap' ? 'selected' : '' }}>• Inventaris Tetap (berisi Kendaraan Bermotor, Alat Elektronik, Mebeler)</option>
                        @foreach($categories as $cat)
                            @if(in_array($cat->id, [2, 3, 4]))
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;- {{ $cat->name }}</option>
                            @endif
                        @endforeach
                        
                        <option value="habis_pakai" class="fw-bold" {{ request('category') == 'habis_pakai' ? 'selected' : '' }}>• Barang Habis Pakai (berisi Barang Habis Pakai / ATK)</option>
                        @foreach($categories as $cat)
                            @if($cat->id == 1)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;- {{ $cat->name }}</option>
                            @endif
                        @endforeach
                        
                        <option value="benda_pos" class="fw-bold" {{ request('category') == 'benda_pos' ? 'selected' : '' }}>• Benda Pos Lainnya (berisi Persediaan Benda Pos, Persediaan Barang Cetakan Lainnya)</option>
                        @foreach($categories as $cat)
                            @if(in_array($cat->id, [5, 6]))
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;- {{ $cat->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;height:42px">Cari Sekarang</button>
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
                        <th class="text-muted fw-semibold px-4 py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">KODE SIMDA</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">NAMA BARANG</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">KATEGORI</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">MERK / LOKASI</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">SATUAN</th>
                        <th class="text-muted fw-semibold py-3 border-0 text-center" style="font-size:0.75rem;letter-spacing:0.5px">STOK</th>
                        <th class="text-muted fw-semibold px-4 py-3 border-0 text-end" style="font-size:0.75rem;letter-spacing:0.5px">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <code class="bg-light rounded px-2 py-1" style="font-size:0.8rem">{{ $item->simda_code }}</code>
                        </td>
                        <td class="py-3">
                            <div class="fw-medium">{{ Str::limit($item->name, 40) }}</div>
                            <small class="text-muted">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                        </td>
                        <td class="py-3">
                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(15,59,115,0.08);color:#0f3b73">{{ $item->category->name }}</span>
                        </td>
                        <td class="py-3 text-muted">
                            <div class="fw-medium text-dark" style="font-size:0.85rem">{{ $item->brand_type ?? '-' }}</div>
                            <small><i class="fas fa-map-marker-alt me-1"></i>{{ $item->location ?? '-' }}</small>
                        </td>
                        <td class="py-3 text-muted">{{ $item->unit->name }}</td>
                        <td class="py-3 text-center">
                            @if($item->stock < 5)
                                <span class="badge bg-danger rounded-pill px-3">{{ $item->stock }}</span>
                            @elseif($item->stock < 10)
                                <span class="badge rounded-pill px-3" style="background:rgba(245,158,11,0.15);color:#d97706">{{ $item->stock }}</span>
                            @else
                                <span class="badge bg-success rounded-pill px-3">{{ $item->stock }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-light rounded-2 me-1" title="Lihat" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                <svg class="text-info" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </a>
                            <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-light rounded-2 me-1" title="Edit" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                <svg style="width:16px;height:16px;color:#c48c2c" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            </a>
                            <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light rounded-2 text-danger" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                    <svg style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                </button>
                            </form>
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
            <svg class="text-muted opacity-25 mb-3" style="width:48px;height:48px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/></svg>
            <p class="text-muted mb-3">Belum ada barang terdaftar.</p>
            <a href="{{ route('items.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">Tambah Sekarang</a>
        </div>
        @endif
    </div>
</div>
@endsection
