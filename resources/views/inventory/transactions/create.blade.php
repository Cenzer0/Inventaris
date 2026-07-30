@extends('layouts.app')

@section('title', 'Catat Transaksi')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    .ts-control {
        border-radius: 10px;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        min-height: 45px;
    }
    .ts-control > input {
        font-size: 1rem;
    }
</style>
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Catat Transaksi Inventaris
        </h4>
        <p class="text-muted mb-0 small">Pencatatan barang masuk dan keluar</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary px-4" style="border-radius:10px">
            <svg class="me-1" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/></svg>
            Kembali
        </a>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px; border-left: 4px solid #dc2626 !important;">
        <strong>Terdapat kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-4">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-4">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="item_id" class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                        <select class="form-select @error('item_id') is-invalid @enderror" 
                                id="item_id" name="item_id" required style="border-radius:10px;height:45px">
                            <option value="">-- Pilih Barang --</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" 
                                    data-stock="{{ $item->stock }}" 
                                    data-price="{{ $item->unit_price }}"
                                    {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} (Stok: {{ $item->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('item_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tipe Transaksi <span class="text-danger">*</span></label>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="transaction_type" id="type_procurement" value="procurement" 
                                       {{ old('transaction_type', 'procurement') == 'procurement' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center" for="type_procurement" style="border-radius:12px">
                                    <svg style="width:24px;height:24px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    <span class="mt-1 fw-bold">Barang Masuk</span>
                                    <small class="text-muted">Pengadaan / Restok</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="transaction_type" id="type_usage" value="usage" 
                                       {{ old('transaction_type') == 'usage' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger w-100 py-3 d-flex flex-column align-items-center" for="type_usage" style="border-radius:12px">
                                    <svg style="width:24px;height:24px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    <span class="mt-1 fw-bold">Barang Keluar</span>
                                    <small class="text-muted">Pemakaian / Distribusi</small>
                                </label>
                            </div>
                        </div>
                        @error('transaction_type')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   id="quantity" name="quantity" value="{{ old('quantity', 1) }}" 
                                   min="1" required style="border-radius:10px;height:45px">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="unit_price" class="form-label fw-semibold">Harga Satuan (Rp)</label>
                            <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                   id="unit_price" name="unit_price" value="{{ old('unit_price') }}" 
                                   min="0" step="1" placeholder="Otomatis dari data barang" style="border-radius:10px;height:45px">
                            @error('unit_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="transaction_date" class="form-label fw-semibold">Tanggal Transaksi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('transaction_date') is-invalid @enderror" 
                               id="transaction_date" name="transaction_date" 
                               value="{{ old('transaction_date', date('Y-m-d')) }}" required style="border-radius:10px;height:45px">
                        @error('transaction_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" placeholder="Catatan transaksi (opsional)" style="border-radius:10px">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px;height:45px">
                            <svg class="me-1" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                            Simpan Transaksi
                        </button>
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary px-4" style="border-radius:10px;height:45px;line-height:30px">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm" style="border-radius:14px">
            <div class="card-body p-4">
                <h6 class="fw-bold text-primary mb-3">
                    <svg class="me-2" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/></svg>
                    Panduan Pencatatan
                </h6>
                <div class="mb-3 p-3 rounded-3" style="background:rgba(16,185,129,0.08)">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-success rounded-pill me-2">Masuk</span>
                        <strong class="small">Barang Masuk (Pengadaan)</strong>
                    </div>
                    <p class="text-muted small mb-0">Digunakan saat menerima barang baru, restok, atau pengadaan. Stok akan <strong>bertambah</strong>.</p>
                </div>
                <div class="mb-3 p-3 rounded-3" style="background:rgba(239,68,68,0.08)">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge bg-danger rounded-pill me-2">Keluar</span>
                        <strong class="small">Barang Keluar (Pemakaian)</strong>
                    </div>
                    <p class="text-muted small mb-0">Digunakan saat barang dikeluarkan, dipakai, atau didistribusikan. Stok akan <strong>berkurang</strong>.</p>
                </div>
                
                <hr class="my-3">
                
                <div class="alert alert-warning border-0 py-2 px-3 mb-0" id="stockWarning" style="display:none; border-radius:10px">
                    <small id="stockWarningText" class="fw-medium"></small>
                </div>
                <div class="alert alert-info border-0 py-2 px-3 mb-0" id="itemInfo" style="display:none; border-radius:10px">
                    <small id="itemInfoText" class="fw-medium"></small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemSelect = document.getElementById('item_id');
        const priceInput = document.getElementById('unit_price');
        
        const tomSelect = new TomSelect("#item_id", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Ketik untuk mencari barang..."
        });
        
        tomSelect.on('change', function(value) {
            const warning = document.getElementById('stockWarning');
            const warningText = document.getElementById('stockWarningText');
            const info = document.getElementById('itemInfo');
            const infoText = document.getElementById('itemInfoText');
            
            if (value) {
                const selectedOption = itemSelect.querySelector('option[value="' + value + '"]');
                const stock = parseInt(selectedOption.dataset.stock || 0);
                const price = selectedOption.dataset.price || '';
                
                // Auto-fill price
                if (price && !priceInput.value) {
                    priceInput.value = price;
                }
                
                info.style.display = 'block';
                infoText.textContent = '📦 Stok saat ini: ' + stock + ' unit | Harga: Rp ' + Number(price).toLocaleString('id-ID');
                
                if (stock < 5) {
                    warning.style.display = 'block';
                    warningText.textContent = '⚠️ Stok rendah (' + stock + ' unit). Pertimbangkan untuk restok!';
                } else {
                    warning.style.display = 'none';
                }
            } else {
                warning.style.display = 'none';
                info.style.display = 'none';
            }
        });

        // Trigger on load if there's an initial value (e.g. from validation error)
        if (tomSelect.getValue()) {
            tomSelect.trigger('change', tomSelect.getValue());
        }
    });
</script>
@endsection
