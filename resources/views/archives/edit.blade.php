@extends('layouts.app')

@section('title', 'Edit Arsip Dokumen')

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
                    <i class="fas fa-file-pen text-warning me-2"></i>
                    Edit Arsip Dokumen
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('archives.update', $archive->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="document_number" class="form-label fw-semibold small">Nomor Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('document_number') is-invalid @enderror" id="document_number" name="document_number" value="{{ old('document_number', $archive->document_number) }}" required style="border-radius:10px">
                            @error('document_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="document_type" class="form-label fw-semibold small">Jenis Dokumen <span class="text-danger">*</span></label>
                            <select class="form-select @error('document_type') is-invalid @enderror" id="document_type" name="document_type" required style="border-radius:10px">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach($documentTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('document_type', $archive->document_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('document_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="title" class="form-label fw-semibold small">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $archive->title) }}" required style="border-radius:10px">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="issued_date" class="form-label fw-semibold small">Tanggal Terbit <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('issued_date') is-invalid @enderror" id="issued_date" name="issued_date" value="{{ old('issued_date', $archive->issued_date->format('Y-m-d')) }}" required style="border-radius:10px">
                            @error('issued_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="issued_by" class="form-label fw-semibold small">Diterbitkan Oleh</label>
                            <input type="text" class="form-control @error('issued_by') is-invalid @enderror" id="issued_by" name="issued_by" value="{{ old('issued_by', $archive->issued_by) }}" style="border-radius:10px">
                            @error('issued_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold small">Deskripsi / Ringkasan</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" style="border-radius:10px">{{ old('description', $archive->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="file" class="form-label fw-semibold small">File PDF</label>
                            <div class="alert alert-light border d-flex align-items-center mb-2 py-2 px-3" style="border-radius:10px">
                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                <span class="small">File saat ini: <strong>{{ basename($archive->file_path) }}</strong> ({{ $archive->formatted_file_size }})</span>
                            </div>
                            <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf" style="border-radius:10px">
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Kosongkan jika tidak ingin mengganti file. Maks 10MB.</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('archives.index') }}" class="btn btn-light px-4" style="border-radius:10px">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
                            <i class="fas fa-save me-1"></i> Perbarui Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
