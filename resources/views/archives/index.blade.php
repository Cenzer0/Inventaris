@extends('layouts.app')

@section('title', 'Arsip Dokumen Hukum')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
            Arsip Dokumen Hukum
        </h4>
        <p class="text-muted small mb-0">Kelola dan arsipkan dokumen-dokumen hukum bagian hukum</p>
    </div>
    @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_gudang']))
    <div class="mt-3 mt-md-0">
        <a href="{{ route('archives.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
            <svg class="me-1" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Tambah Dokumen
        </a>
    </div>
    @endif
</div>

{{-- Search & Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-body py-3 px-4">
        <form action="{{ route('archives.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label text-muted small fw-semibold mb-1">Cari Dokumen</label>
                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari judul, nomor, tahun terbit..." style="border-radius:10px">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small fw-semibold mb-1">Jenis Dokumen</label>
                <select name="type" class="form-select" style="border-radius:10px">
                    <option value="all">Semua Jenis</option>
                    @foreach($documentTypes as $key => $label)
                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" style="border-radius:10px">Filter</button>
                @if(request('search') || request('type'))
                <a href="{{ route('archives.index') }}" class="btn btn-outline-secondary" style="border-radius:10px">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.875rem">
                <thead>
                    <tr style="background:#f8fafc">
                        <th class="text-muted fw-semibold px-4 py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px;width:55px">NO</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">DOKUMEN</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">JENIS</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">TANGGAL</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">UKURAN</th>
                        <th class="text-muted fw-semibold px-4 py-3 border-0 text-end" style="font-size:0.75rem;letter-spacing:0.5px">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($archives as $index => $archive)
                    @php
                        $typeColors = [
                            'perda' => ['bg' => 'rgba(15,59,115,0.1)', 'text' => '#0f3b73'],
                            'perbup' => ['bg' => 'rgba(16,185,129,0.1)', 'text' => '#10b981'],
                            'sk' => ['bg' => 'rgba(196,140,44,0.1)', 'text' => '#c48c2c'],
                            'surat_perjanjian' => ['bg' => 'rgba(139,92,246,0.1)', 'text' => '#8b5cf6'],
                            'mou' => ['bg' => 'rgba(236,72,153,0.1)', 'text' => '#ec4899'],
                            'lainnya' => ['bg' => 'rgba(107,114,128,0.1)', 'text' => '#6b7280'],
                        ];
                        $color = $typeColors[$archive->document_type] ?? $typeColors['lainnya'];
                    @endphp
                    <tr>
                        <td class="px-4 py-3 text-muted">{{ $archives->firstItem() + $index }}</td>
                        <td class="py-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-2 d-flex align-items-center justify-content-center me-3 flex-shrink-0 mt-1" style="width:38px;height:38px;background:rgba(239,68,68,0.08)">
                                    <i class="fas fa-file-pdf" style="color:#ef4444;font-size:1rem"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-dark text-wrap mb-1" style="max-width:320px; line-height: 1.4;">{{ $archive->title }}</div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-1 px-2 py-1" style="font-size:0.7rem; font-weight:600;">
                                            Tahun: {{ $archive->issued_date->format('Y') }}
                                        </span>
                                        <span class="text-muted" style="font-size:0.75rem"><i class="fas fa-hashtag me-1"></i>{{ $archive->document_number }}</span>
                                    </div>
                                    @if($archive->description)
                                    <div class="text-muted text-truncate" style="font-size:0.75rem; max-width:320px;" title="{{ $archive->description }}">
                                        <i class="fas fa-info-circle me-1"></i>{{ $archive->description }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <span class="badge rounded-pill px-3 py-1" style="background:{{ $color['bg'] }};color:{{ $color['text'] }};font-weight:600;font-size:0.72rem">
                                {{ $archive->document_type_label }}
                            </span>
                        </td>
                        <td class="py-3 text-muted" style="font-size:0.85rem">{{ $archive->issued_date->format('d M Y') }}</td>
                        <td class="py-3 text-muted" style="font-size:0.85rem">{{ $archive->formatted_file_size }}</td>
                        <td class="px-4 py-3 text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('archives.show', $archive->id) }}" class="btn btn-sm btn-light rounded-2" title="Detail" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                    <i class="fas fa-eye" style="color:#0f3b73;font-size:0.8rem"></i>
                                </a>
                                <a href="{{ route('archives.download', $archive->id) }}" class="btn btn-sm btn-light rounded-2" title="Download" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                    <i class="fas fa-download" style="color:#10b981;font-size:0.8rem"></i>
                                </a>
                                @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_gudang']))
                                <a href="{{ route('archives.edit', $archive->id) }}" class="btn btn-sm btn-light rounded-2" title="Edit" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                    <i class="fas fa-pen" style="color:#c48c2c;font-size:0.8rem"></i>
                                </a>
                                <form action="{{ route('archives.destroy', $archive->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light rounded-2" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" title="Hapus" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                        <i class="fas fa-trash" style="color:#ef4444;font-size:0.8rem"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-folder-open text-muted opacity-25 mb-3" style="font-size:3rem"></i>
                            <h6 class="text-muted fw-semibold mb-1">Belum Ada Arsip Dokumen</h6>
                            <p class="text-muted small mb-0">Dokumen yang diarsipkan akan muncul di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($archives->hasPages())
        <div class="p-4 d-flex justify-content-center">
            {{ $archives->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
