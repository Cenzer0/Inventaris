@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1>Edit Barang</h1>
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
                <form action="{{ route('items.update', $item) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="simda_code" class="form-label">Kode SIMDA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('simda_code') is-invalid @enderror" 
                                   id="simda_code" name="simda_code" value="{{ old('simda_code', $item->simda_code) }}" required>
                            @error('simda_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $item->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
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
                                        <option value="{{ $cat->id }}" data-type="{{ $catType }}" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                                </optgroup>
                                <optgroup label="Barang Habis Pakai (berisi Barang Habis Pakai / ATK)">
                                @foreach($categories as $cat)
                                    @if($cat->id == 1)
                                        <option value="{{ $cat->id }}" data-type="Umum" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endif
                                @endforeach
                                </optgroup>
                                <optgroup label="Benda Pos Lainnya (berisi Persediaan Benda Pos, Persediaan Barang Cetakan Lainnya)">
                                @foreach($categories as $cat)
                                    @if(in_array($cat->id, [5, 6]))
                                        <option value="{{ $cat->id }}" data-type="Umum" {{ old('category_id', $item->category_id) == $cat->id ? 'selected' : '' }}>
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
                                    <option value="{{ $unit->id }}" {{ old('unit_id', $item->unit_id) == $unit->id ? 'selected' : '' }}>
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
                                   id="unit_price" name="unit_price" value="{{ old('unit_price', $item->unit_price) }}" 
                                   step="0.01" min="0" required>
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', $item->stock) }}" 
                                   min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="item_type" id="item_type" value="{{ old('item_type', $item->item_type) }}">
                    @error('item_type')
                        <div class="text-danger small mb-3">{{ $message }}</div>
                    @enderror

                    <div class="row">
                        <div class="col-md-6 mb-3" id="purchase_date_container" style="display: {{ in_array(old('item_type', $item->item_type), ['Elektronik', 'Kendaraan', 'Mebeler']) ? 'block' : 'none' }};">
                            <label for="purchase_date" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                   id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $item->purchase_date ? \Carbon\Carbon::parse($item->purchase_date)->format('Y-m-d') : '') }}">
                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3" id="last_service_date_container" style="display: {{ old('item_type', $item->item_type) == 'Kendaraan' ? 'block' : 'none' }};">
                            <label for="last_service_date" class="form-label">Tgl Servis Terakhir</label>
                            <input type="date" class="form-control @error('last_service_date') is-invalid @enderror" 
                                   id="last_service_date" name="last_service_date" value="{{ old('last_service_date', $item->last_service_date ? \Carbon\Carbon::parse($item->last_service_date)->format('Y-m-d') : '') }}">
                            @error('last_service_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row" id="tax_month_row" style="display: {{ old('item_type', $item->item_type) == 'Kendaraan' ? 'flex' : 'none' }};">
                        <div class="col-md-4 mb-3">
                            <label for="tax_month" class="form-label">Bulan Pajak Kendaraan</label>
                            <select class="form-select @error('tax_month') is-invalid @enderror" id="tax_month" name="tax_month">
                                <option value="">-- Pilih Bulan Pajak --</option>
                                @foreach(\App\Models\Item::MONTH_NAMES as $num => $name)
                                    <option value="{{ $num }}" {{ old('tax_month', $item->tax_month) == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"><i class="fas fa-info-circle me-1"></i>Bulan jatuh tempo pembayaran pajak kendaraan.</div>
                            @error('tax_month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row" id="depreciation_fields_container" style="display: {{ in_array(old('item_type', $item->item_type), ['Elektronik', 'Kendaraan', 'Mebeler']) ? 'flex' : 'none' }};">
                        <div class="col-md-6 mb-3">
                            <label for="useful_life" class="form-label">Masa Manfaat (Tahun)</label>
                            <input type="number" class="form-control @error('useful_life') is-invalid @enderror" 
                                   id="useful_life" name="useful_life" value="{{ old('useful_life', $item->useful_life) }}" min="1">
                            <div class="form-text">Estimasi umur ekonomis barang (dalam tahun) untuk penyusutan.</div>
                            @error('useful_life')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="residual_value" class="form-label">Nilai Residu (Rp)</label>
                            <input type="number" class="form-control @error('residual_value') is-invalid @enderror" 
                                   id="residual_value" name="residual_value" value="{{ old('residual_value', $item->residual_value ?? 0) }}" min="0" step="0.01">
                            <div class="form-text">Nilai sisa aset setelah masa manfaat berakhir (bisa diisi 0 jika habis).</div>
                            @error('residual_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="mb-3">Detail Tambahan (Opsional)</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="asset_category" class="form-label">Kategori Aset</label>
                            <input type="text" class="form-control @error('asset_category') is-invalid @enderror" 
                                   id="asset_category" name="asset_category" value="{{ old('asset_category', $item->asset_category) }}">
                            @error('asset_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="registration_number" class="form-label">No. Urut Pend.</label>
                            <input type="text" class="form-control @error('registration_number') is-invalid @enderror" 
                                   id="registration_number" name="registration_number" value="{{ old('registration_number', $item->registration_number) }}">
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="register_number" class="form-label">No. Register</label>
                            <input type="text" class="form-control @error('register_number') is-invalid @enderror" 
                                   id="register_number" name="register_number" value="{{ old('register_number', $item->register_number) }}">
                            @error('register_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="brand_type" class="form-label">Merk/Type</label>
                            <input type="text" class="form-control @error('brand_type') is-invalid @enderror" 
                                   id="brand_type" name="brand_type" value="{{ old('brand_type', $item->brand_type) }}">
                            @error('brand_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="size_spec" class="form-label">Ukuran/CC</label>
                            <input type="text" class="form-control @error('size_spec') is-invalid @enderror" 
                                   id="size_spec" name="size_spec" value="{{ old('size_spec', $item->size_spec) }}">
                            @error('size_spec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="material" class="form-label">Bahan</label>
                            <input type="text" class="form-control @error('material') is-invalid @enderror" 
                                   id="material" name="material" value="{{ old('material', $item->material) }}">
                            @error('material')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="factory_number" class="form-label">No. Pabrik</label>
                            <input type="text" class="form-control @error('factory_number') is-invalid @enderror" 
                                   id="factory_number" name="factory_number" value="{{ old('factory_number', $item->factory_number) }}">
                            @error('factory_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="chassis_number" class="form-label">No. Rangka</label>
                            <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" 
                                   id="chassis_number" name="chassis_number" value="{{ old('chassis_number', $item->chassis_number) }}">
                            @error('chassis_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="engine_number" class="form-label">No. Mesin</label>
                            <input type="text" class="form-control @error('engine_number') is-invalid @enderror" 
                                   id="engine_number" name="engine_number" value="{{ old('engine_number', $item->engine_number) }}">
                            @error('engine_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="license_plate" class="form-label">No. Polisi</label>
                            <input type="text" class="form-control @error('license_plate') is-invalid @enderror" 
                                   id="license_plate" name="license_plate" value="{{ old('license_plate', $item->license_plate) }}">
                            @error('license_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="bpkb_number" class="form-label">No. BPKB</label>
                            <input type="text" class="form-control @error('bpkb_number') is-invalid @enderror" 
                                   id="bpkb_number" name="bpkb_number" value="{{ old('bpkb_number', $item->bpkb_number) }}">
                            @error('bpkb_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="acquisition_source" class="form-label">Asal Usul</label>
                            <input type="text" class="form-control @error('acquisition_source') is-invalid @enderror" 
                                   id="acquisition_source" name="acquisition_source" value="{{ old('acquisition_source', $item->acquisition_source) }}">
                            @error('acquisition_source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="location" class="form-label">Ruang/Lokasi</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location', $item->location) }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Perbarui
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
