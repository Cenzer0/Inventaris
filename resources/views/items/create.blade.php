@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Tambah Barang Baru</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('items.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('items.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="simda_code" class="form-label">Kode SIMDA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('simda_code') is-invalid @enderror" 
                                   id="simda_code" name="simda_code" value="{{ old('simda_code') }}" required>
                            @error('simda_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required onchange="updateItemType()">
                                <option value="">-- Pilih Kategori --</option>
                                <optgroup label="Inventaris Tetap (berisi Kendaraan Bermotor, Alat Elektronik, Mebeler)">
                                @foreach($categories as $cat)
                                    @if(in_array($cat->id, [2, 3, 4]))
                                        @php
                                            $catType = 'Umum';
                                            if($cat->id == 2) $catType = 'Elektronik';
                                            if($cat->id == 3) $catType = 'Kendaraan';
                                            if($cat->id == 4) $catType = 'Mebeler';
                                        @endphp
                                        <option value="{{ $cat->id }}" data-type="{{ $catType }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                                </optgroup>
                                <optgroup label="Barang Habis Pakai (berisi Barang Habis Pakai / ATK)">
                                @foreach($categories as $cat)
                                    @if($cat->id == 1)
                                        <option value="{{ $cat->id }}" data-type="Umum" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                                </optgroup>
                                <optgroup label="Benda Pos Lainnya (berisi Persediaan Benda Pos, Persediaan Barang Cetakan Lainnya)">
                                @foreach($categories as $cat)
                                    @if(in_array($cat->id, [5, 6]))
                                        <option value="{{ $cat->id }}" data-type="Umum" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                                </optgroup>
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="unit_id" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select class="form-select @error('unit_id') is-invalid @enderror" 
                                    id="unit_id" name="unit_id" required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="unit_price" class="form-label">Harga Satuan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                   id="unit_price" name="unit_price" value="{{ old('unit_price', 0) }}" 
                                   step="0.01" min="0" required>
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', 0) }}" 
                                   min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="item_type" id="item_type" value="{{ old('item_type', 'Umum') }}">
                    @error('item_type')
                        <div class="text-danger small mb-3">{{ $message }}</div>
                    @enderror

                    <div class="row">
                        <div class="col-md-6 mb-3" id="purchase_date_container" style="display: {{ in_array(old('item_type'), ['Elektronik', 'Kendaraan', 'Mebeler']) ? 'block' : 'none' }};">
                            <label for="purchase_date" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                   id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}">
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3" id="last_service_date_container" style="display: {{ old('item_type') == 'Kendaraan' ? 'block' : 'none' }};">
                            <label for="last_service_date" class="form-label">Tgl Servis Terakhir</label>
                            <input type="date" class="form-control @error('last_service_date') is-invalid @enderror" 
                                   id="last_service_date" name="last_service_date" value="{{ old('last_service_date') }}">
                            @error('last_service_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row" id="tax_month_row" style="display: {{ old('item_type') == 'Kendaraan' ? 'flex' : 'none' }};">
                        <div class="col-md-4 mb-3">
                            <label for="tax_month" class="form-label">Bulan Pajak Kendaraan</label>
                            <select class="form-select @error('tax_month') is-invalid @enderror" id="tax_month" name="tax_month">
                                <option value="">-- Pilih Bulan Pajak --</option>
                                @foreach(\App\Models\Item::MONTH_NAMES as $num => $name)
                                    <option value="{{ $num }}" {{ old('tax_month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Bulan jatuh tempo pembayaran pajak kendaraan.</div>
                            @error('tax_month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row" id="depreciation_fields_container" style="display: {{ in_array(old('item_type'), ['Elektronik', 'Kendaraan', 'Mebeler']) ? 'flex' : 'none' }};">
                        <div class="col-md-6 mb-3">
                            <label for="useful_life" class="form-label">Masa Manfaat (Tahun)</label>
                            <input type="number" class="form-control @error('useful_life') is-invalid @enderror" 
                                   id="useful_life" name="useful_life" value="{{ old('useful_life') }}" min="1">
                            <div class="form-text">Estimasi umur ekonomis barang (dalam tahun) untuk penyusutan.</div>
                            @error('useful_life')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="residual_value" class="form-label">Nilai Residu (Rp)</label>
                            <input type="number" class="form-control @error('residual_value') is-invalid @enderror" 
                                   id="residual_value" name="residual_value" value="{{ old('residual_value', 0) }}" min="0" step="0.01">
                            <div class="form-text">Nilai sisa aset setelah masa manfaat berakhir (bisa diisi 0 jika habis).</div>
                            @error('residual_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateItemType() {
    var categorySelect = document.getElementById('category_id');
    var selectedOption = categorySelect.options[categorySelect.selectedIndex];
    
    if (selectedOption && selectedOption.value) {
        var optType = selectedOption.getAttribute('data-type');
        document.getElementById('item_type').value = optType;
    } else {
        document.getElementById('item_type').value = 'Umum';
    }
    toggleDateFields();
}

function toggleDateFields() {
    var type = document.getElementById('item_type').value;
    var purchaseContainer = document.getElementById('purchase_date_container');
    var serviceContainer = document.getElementById('last_service_date_container');
    var taxMonthRow = document.getElementById('tax_month_row');
    var depreciationFields = document.getElementById('depreciation_fields_container');

    if(type === 'Elektronik' || type === 'Kendaraan' || type === 'Mebeler') {
        purchaseContainer.style.display = 'block';
        depreciationFields.style.display = 'flex';
    } else {
        purchaseContainer.style.display = 'none';
        depreciationFields.style.display = 'none';
    }

    if(type === 'Kendaraan') {
        serviceContainer.style.display = 'block';
        taxMonthRow.style.display = 'flex';
    } else {
        serviceContainer.style.display = 'none';
        taxMonthRow.style.display = 'none';
    }
}

// Run on load to set initial state
document.addEventListener('DOMContentLoaded', function() {
    if(document.getElementById('category_id').value === "") {
        document.getElementById('item_type').value = 'Umum';
    }
    toggleDateFields();
});
</script>
@endsection
