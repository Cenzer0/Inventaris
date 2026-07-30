@extends('layouts.app')

@section('title', 'Detail Dokumen - ' . $archive->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('archives.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row g-4">
    {{-- Detail Card --}}
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-header bg-white border-bottom py-3 px-4" style="border-radius:14px 14px 0 0">
                <h5 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="fas fa-file-pdf text-danger me-2"></i>
                    Detail Dokumen
                </h5>
            </div>
            <div class="card-body p-4">
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

                <div class="mb-4">
                    <span class="badge rounded-pill px-3 py-2" style="background:{{ $color['bg'] }};color:{{ $color['text'] }};font-weight:600;font-size:0.8rem">
                        {{ $archive->document_type_label }}
                    </span>
                </div>

                <table class="table table-borderless mb-0" style="font-size:0.875rem">
                    <tr>
                        <td class="text-muted fw-semibold ps-0" style="width:140px">Nomor Dokumen</td>
                        <td class="fw-medium">{{ $archive->document_number }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold ps-0">Judul</td>
                        <td class="fw-medium">{{ $archive->title }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold ps-0">Tanggal Terbit</td>
                        <td>{{ $archive->issued_date->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold ps-0">Diterbitkan Oleh</td>
                        <td>{{ $archive->issued_by ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold ps-0">Ukuran File</td>
                        <td>{{ $archive->formatted_file_size }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold ps-0">Diupload Oleh</td>
                        <td>{{ $archive->uploader->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold ps-0">Tanggal Upload</td>
                        <td>{{ $archive->created_at->format('d F Y, H:i') }}</td>
                    </tr>
                </table>

                @if($archive->description)
                <div class="mt-3 pt-3 border-top">
                    <div class="text-muted fw-semibold small mb-2">Deskripsi</div>
                    <p class="mb-0" style="font-size:0.875rem;line-height:1.7">{{ $archive->description }}</p>
                </div>
                @endif

                <div class="mt-4 pt-3 border-top d-flex gap-2 flex-wrap">
                    <a href="{{ route('archives.download', $archive->id) }}" class="btn btn-primary px-4" style="border-radius:10px">
                        <i class="fas fa-download me-1"></i> Download PDF
                    </a>
                    @if(auth()->check() && in_array(auth()->user()->role, ['superadmin', 'admin_gudang']))
                    <a href="{{ route('archives.edit', $archive->id) }}" class="btn btn-outline-warning px-4" style="border-radius:10px">
                        <i class="fas fa-pen me-1"></i> Edit
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- PDF Preview --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center" style="border-radius:14px 14px 0 0">
                <h5 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="fas fa-eye text-primary me-2"></i>
                    Preview Dokumen
                </h5>
                <a href="{{ route('archives.preview', $archive->id) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Tab Baru
                </a>
            </div>
            <div class="card-body p-0" style="border-radius:0 0 14px 14px;overflow:hidden">
                <iframe src="{{ route('archives.preview', $archive->id) }}" style="width:100%;height:700px;border:none"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
