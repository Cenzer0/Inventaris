@extends('layouts.app')

@section('title', 'Daftar Satuan')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/></svg>
            Daftar Satuan
        </h4>
        <p class="text-muted small mb-0">Kelola satuan pengukuran barang</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('units.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
            <svg class="me-1" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Tambah Satuan
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        @if($units->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.875rem">
                <thead>
                    <tr style="background:#f8fafc">
                        <th class="text-muted fw-semibold px-4 py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px;width:60px">NO</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">NAMA SATUAN</th>
                        <th class="text-muted fw-semibold py-3 border-0 text-center" style="font-size:0.75rem;letter-spacing:0.5px">JUMLAH BARANG</th>
                        <th class="text-muted fw-semibold px-4 py-3 border-0 text-end" style="font-size:0.75rem;letter-spacing:0.5px">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $unit)
                    <tr>
                        <td class="px-4 py-3 text-muted">{{ ($units->currentPage() - 1) * $units->perPage() + $loop->iteration }}</td>
                        <td class="py-3 fw-medium">{{ $unit->name }}</td>
                        <td class="py-3 text-center">
                            <span class="badge rounded-pill px-3 py-2" style="background:rgba(15,59,115,0.08);color:#0f3b73">{{ $unit->items_count }} item</span>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('units.edit', $unit) }}" class="btn btn-sm btn-light rounded-2 me-1" title="Edit" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                <svg style="width:16px;height:16px;color:#c48c2c" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            </a>
                            <form action="{{ route('units.destroy', $unit) }}" method="POST" class="d-inline">
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
            {{ $units->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <svg class="text-muted opacity-25 mb-3" style="width:48px;height:48px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/></svg>
            <p class="text-muted mb-3">Belum ada satuan terdaftar.</p>
            <a href="{{ route('units.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">Tambah Sekarang</a>
        </div>
        @endif
    </div>
</div>
@endsection
