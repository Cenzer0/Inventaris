@extends('layouts.app')

@section('title', 'Tambah Arsip Dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="{{ route('archives.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-header bg-white border-bottom py-3 px-4" style="border-radius:14px 14px 0 0">
                <h5 class="fw-bold mb-0 d-flex align-items-center">
                    <i class="fas fa-file-circle-plus text-primary me-2"></i>
                    Tambah Arsip Dokumen Baru
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('archives.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="alert alert-primary border-0" style="border-radius:10px">
                        <i class="fas fa-magic me-2"></i>
                        Cukup unggah file PDF saja. Sistem akan secara otomatis <strong>membaca isi teks di dalam dokumen PDF</strong> untuk mengisi Nomor Dokumen, Jenis, Judul, dan Tanggal Terbit.
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="file" class="form-label fw-semibold small">File PDF <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept="application/pdf,.pdf" required style="border-radius:10px">
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Hanya file PDF dengan ukuran maksimal 10MB.</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('archives.index') }}" class="btn btn-light px-4" style="border-radius:10px">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
                            <i class="fas fa-save me-1"></i> Simpan Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
