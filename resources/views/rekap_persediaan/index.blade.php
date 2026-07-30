@extends('layouts.app')

@section('title', 'Rekapitulasi Persediaan Barang')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <i class="fas fa-file-invoice text-primary me-2"></i>
            Rekapitulasi Persediaan Barang Pakai Habis
        </h4>
        <p class="text-muted small mb-0">Format SIMDA - Laporan Bulanan</p>
    </div>
    
    <div class="mt-3 mt-md-0 d-flex gap-2">
        <a href="{{ route('rekap.export.pdf', ['bulan' => $inputBulan]) }}" target="_blank" class="btn btn-outline-danger btn-sm px-3" style="border-radius:8px">
            <i class="fas fa-file-pdf me-1"></i> PDF
        </a>
        <a href="{{ route('rekap.export.excel', ['bulan' => $inputBulan]) }}" target="_blank" class="btn btn-outline-success btn-sm px-3" style="border-radius:8px">
            <i class="fas fa-file-excel me-1"></i> Excel
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('transactions.report') }}" class="row g-3 align-items-end">
            <div class="col-md-8">
                <label class="form-label small fw-semibold text-muted mb-1">Pilih Bulan</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <i class="bi bi-calendar-month text-muted"></i>
                    </span>
                    <input type="month" name="bulan" class="form-control border-start-0" style="border-radius:0 10px 10px 0" value="{{ $inputBulan }}">
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; height:42px">
                    <i class="fas fa-filter me-1"></i> Cari Data
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .rekap-table-wrapper {
        max-height: 75vh;
        overflow: auto;
    }
    .rekap-table th, .rekap-table td {
        vertical-align: middle;
        white-space: nowrap;
    }
    .rekap-table thead th {
        position: sticky;
        top: 0;
        background-color: #f8fafc;
        z-index: 2;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    /* Sticky No Urut */
    .sticky-no {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: #fff;
    }
    .rekap-table thead th.sticky-no {
        z-index: 3;
        background-color: #f8fafc;
    }
    /* Sticky Nama Barang */
    .sticky-name {
        position: sticky;
        left: 40px;
        min-width: 200px;
        max-width: 250px;
        white-space: normal !important;
        z-index: 1;
        background-color: #fff;
        /* Remove box-shadow from here, apply to satuan */
    }
    .rekap-table thead th.sticky-name {
        z-index: 3;
        background-color: #f8fafc;
    }
    
    /* Sticky Satuan */
    .sticky-satuan {
        position: sticky;
        left: 240px; /* 40px + 200px min-width */
        z-index: 1;
        background-color: #fff;
        box-shadow: 1px 0 0 rgba(0,0,0,0.05);
    }
    .rekap-table thead th.sticky-satuan {
        z-index: 3;
        background-color: #f8fafc;
    }
    
    /* Make group headers stick nicely */
    .group-header td {
        background-color: #f1f5f9 !important;
        position: sticky;
        left: 0;
        z-index: 1;
    }
</style>

<div class="card border-0 shadow-sm" style="border-radius:20px; overflow: hidden; background: #fff;">
    <div class="card-header bg-white border-bottom py-3 px-4">
         <h6 class="fw-bold mb-0 text-primary">Data Rekapitulasi: {{ $queryBulan }}</h6>
    </div>
    <div class="card-body p-0">
        <div class="rekap-table-wrapper">
            <table class="table table-bordered table-hover align-middle mb-0 rekap-table table-sm" style="font-size:0.7rem;">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2" class="text-muted fw-bold sticky-no" style="width: 40px; min-width: 40px;">NO</th>
                        <th rowspan="2" class="text-muted fw-bold sticky-name" style="width: 200px; min-width: 200px; max-width: 200px;">NAMA / JENIS BARANG</th>
                        <th rowspan="2" class="text-muted fw-bold sticky-satuan" style="width: 80px; min-width: 80px;">SATUAN</th>
                        <th colspan="3" class="text-muted fw-bold">SISA BULAN LALU</th>
                        <th colspan="3" class="text-muted fw-bold">PENGADAAN BLN INI</th>
                        <th colspan="2" class="text-muted fw-bold">JUMLAH</th>
                        <th colspan="3" class="text-muted fw-bold">PEMAKAIAN BLN INI</th>
                        <th colspan="2" class="text-muted fw-bold">SISA</th>
                        <th rowspan="2" class="text-muted fw-bold">KET</th>
                    </tr>
                    <tr>
                        <th class="text-muted fw-semibold">Vol</th>
                        <th class="text-muted fw-semibold">Harga Satuan</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Vol</th>
                        <th class="text-muted fw-semibold">Harga Satuan</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Vol</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Vol</th>
                        <th class="text-muted fw-semibold">Harga Satuan</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Vol</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotalSisaLalu = 0;
                        $grandTotalPengadaan = 0;
                        $grandTotalJumlah = 0;
                        $grandTotalPemakaian = 0;
                        $grandTotalSisaAkhir = 0;
                        
                        $roman = ['1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '5' => 'V'];
                        $groupIndex = 1;
                    @endphp

                    @forelse($grouped as $categoryName => $items)
                        @php
                            $subTotalSisaLalu = 0;
                            $subTotalPengadaan = 0;
                            $subTotalJumlah = 0;
                            $subTotalPemakaian = 0;
                            $subTotalSisaAkhir = 0;
                        @endphp
                        
                        {{-- Group Header --}}
                        <tr class="group-header">
                            <td class="text-center fw-bold sticky-no" style="background-color: #f1f5f9;">{{ $roman[$groupIndex] ?? $groupIndex }}</td>
                            <td class="fw-bold sticky-name" style="background-color: #f1f5f9; z-index: 2;">{{ $categoryName }}</td>
                            <td colspan="15" style="background-color: #f1f5f9;"></td>
                        </tr>

                        @foreach($items as $index => $row)
                            @php
                                $subTotalSisaLalu += $row->sisa_lalu_total;
                                $subTotalPengadaan += $row->pengadaan_total;
                                $subTotalJumlah += $row->jumlah_harga;
                                $subTotalPemakaian += $row->pemakaian_total;
                                $subTotalSisaAkhir += $row->sisa_harga;
                            @endphp
                            <tr>
                                <td class="text-center sticky-no">{{ $index + 1 }}</td>
                                <td class="sticky-name">{{ $row->item->name }}</td>
                                <td class="text-center sticky-satuan">{{ $row->item->unit->name ?? 'pcs' }}</td>
                                
                                <td class="text-center">{{ $row->sisa_lalu_volume }}</td>
                                <td class="text-end">{{ number_format($row->sisa_lalu_harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($row->sisa_lalu_total, 0, ',', '.') }}</td>
                                
                                <td class="text-center">{{ $row->pengadaan_volume }}</td>
                                <td class="text-end">{{ number_format($row->pengadaan_harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($row->pengadaan_total, 0, ',', '.') }}</td>
                                
                                <td class="text-center fw-medium">{{ $row->jumlah_volume }}</td>
                                <td class="text-end fw-medium">{{ number_format($row->jumlah_harga, 0, ',', '.') }}</td>
                                
                                <td class="text-center">{{ $row->pemakaian_volume }}</td>
                                <td class="text-end">{{ number_format($row->pemakaian_harga_satuan, 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($row->pemakaian_total, 0, ',', '.') }}</td>
                                
                                <td class="text-center fw-bold">{{ $row->sisa_volume }}</td>
                                <td class="text-end fw-bold">{{ number_format($row->sisa_harga, 0, ',', '.') }}</td>
                                
                                <td>{{ $row->keterangan }}</td>
                            </tr>
                        @endforeach
                        
                        {{-- Sub Total Row --}}
                        <tr class="fw-bold" style="background-color:rgba(15,59,115,0.03)">
                            <td class="text-end text-primary sticky-no" style="background-color: #f8fafc;"></td>
                            <td class="text-end text-primary sticky-name" style="background-color: #f8fafc; z-index: 2;">Sub Total {{ $roman[$groupIndex] ?? $groupIndex }} :</td>
                            <td class="sticky-satuan" style="background-color: #f8fafc; z-index: 2;"></td>
                            <td colspan="2" class="text-end text-primary"></td>
                            <td class="text-end text-primary">{{ number_format($subTotalSisaLalu, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                            <td class="text-end text-primary">{{ number_format($subTotalPengadaan, 0, ',', '.') }}</td>
                            <td></td>
                            <td class="text-end text-primary">{{ number_format($subTotalJumlah, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                            <td class="text-end text-primary">{{ number_format($subTotalPemakaian, 0, ',', '.') }}</td>
                            <td></td>
                            <td class="text-end text-primary">{{ number_format($subTotalSisaAkhir, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>

                        @php
                            $grandTotalSisaLalu += $subTotalSisaLalu;
                            $grandTotalPengadaan += $subTotalPengadaan;
                            $grandTotalJumlah += $subTotalJumlah;
                            $grandTotalPemakaian += $subTotalPemakaian;
                            $grandTotalSisaAkhir += $subTotalSisaAkhir;
                            $groupIndex++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="17" class="text-center py-4">Belum ada data rekapitulasi untuk bulan ini.</td>
                        </tr>
                    @endforelse
                    
                    {{-- Grand Total Row --}}
                    @if($grouped->count() > 0)
                    <tr class="fw-bold text-white" style="background-color:#0f3b73">
                        <td class="text-end sticky-no" style="background-color: #0f3b73;"></td>
                        <td class="text-end sticky-name" style="background-color: #0f3b73; z-index: 2;">TOTAL KESELURUHAN (I+II+III) :</td>
                        <td class="sticky-satuan" style="background-color: #0f3b73; z-index: 2;"></td>
                        <td colspan="2" class="text-end"></td>
                        <td class="text-end">{{ number_format($grandTotalSisaLalu, 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                        <td class="text-end">{{ number_format($grandTotalPengadaan, 0, ',', '.') }}</td>
                        <td></td>
                        <td class="text-end">{{ number_format($grandTotalJumlah, 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                        <td class="text-end">{{ number_format($grandTotalPemakaian, 0, ',', '.') }}</td>
                        <td></td>
                        <td class="text-end">{{ number_format($grandTotalSisaAkhir, 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    body { visibility: hidden; }
    .card, .table { visibility: visible; position: absolute; left: 0; top: 0; width: 100%; }
    .d-flex.mb-4 { display: none !important; }
    .table td, .table th { font-size: 10px !important; padding: 4px !important; }
}
</style>
@endsection
