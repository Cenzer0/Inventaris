@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi Persediaan')

@section('content')
{{-- Page Header --}}
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/></svg>
            Laporan Rekapitulasi Persediaan
        </h4>
        <p class="text-muted mb-0 small">Ringkasan pergerakan stok barang per kategori</p>
    </div>
    <div class="d-flex gap-2 mt-3 mt-md-0">
        <form method="GET" action="{{ route('transactions.export.pdf', ['startDate' => request('startDate', $startDate->format('Y-m-d')), 'endDate' => request('endDate', $endDate->format('Y-m-d'))]) }}" target="_blank" class="d-inline">
            <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                <i class="fas fa-file-pdf me-1"></i> PDF
            </button>
        </form>
        <form method="GET" action="{{ route('transactions.export.excel', ['startDate' => request('startDate', $startDate->format('Y-m-d')), 'endDate' => request('endDate', $endDate->format('Y-m-d'))]) }}" target="_blank" class="d-inline">
            <button type="submit" class="btn btn-outline-success btn-sm px-3">
                <i class="fas fa-file-excel me-1"></i> Excel
            </button>
        </form>
    </div>
</div>

{{-- Date Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('transactions.report') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Dari Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <i class="bi bi-calendar-date text-muted"></i>
                    </span>
                    <input type="date" class="form-control border-start-0" style="border-radius:0 10px 10px 0" name="startDate" value="{{ request('startDate', $startDate->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Sampai Tanggal</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius:10px 0 0 10px">
                        <i class="bi bi-calendar-check text-muted"></i>
                    </span>
                    <input type="date" class="form-control border-start-0" style="border-radius:0 10px 10px 0" name="endDate" value="{{ request('endDate', $endDate->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:10px; height:42px">
                    <i class="fas fa-filter me-1"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Rekapitulasi Table --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-header bg-white border-bottom py-3 px-4">
         <h6 class="fw-bold mb-0 text-primary">Matriks Rekapitulasi Persediaan</h6>
    </div>
    <div class="card-body p-0">
        @if(count($reportData) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle mb-0" style="font-size:0.8rem">
                <thead class="text-center align-middle" style="background:#f8fafc">
                    <tr>
                        <th rowspan="2" class="text-muted fw-bold">NO URUT</th>
                        <th rowspan="2" class="text-muted fw-bold" style="min-width:250px">NAMA / JENIS BARANG</th>
                        <th rowspan="2" class="text-muted fw-bold">SATUAN</th>
                        <th colspan="3" class="text-muted fw-bold">SISA BULAN LALU</th>
                        <th colspan="3" class="text-muted fw-bold">PENGADAAN BLN INI</th>
                        <th colspan="2" class="text-muted fw-bold">JUMLAH</th>
                        <th colspan="3" class="text-muted fw-bold">PEMAKAIAN BLN INI</th>
                        <th colspan="2" class="text-muted fw-bold">SISA</th>
                        <th rowspan="2" class="text-muted fw-bold">KET</th>
                    </tr>
                    <tr>
                        <th class="text-muted fw-semibold">Volume</th>
                        <th class="text-muted fw-semibold">Harga Satuan</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Volume</th>
                        <th class="text-muted fw-semibold">Harga Satuan</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Volume</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Volume</th>
                        <th class="text-muted fw-semibold">Harga Satuan</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                        <th class="text-muted fw-semibold">Volume</th>
                        <th class="text-muted fw-semibold">Jumlah Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $roman = ['1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '5' => 'V'];
                        $groupIndex = 1;
                    @endphp
                    @foreach($reportData as $cat)
                    <tr style="background-color:rgba(15,59,115,0.03)">
                        <td class="text-center fw-bold">{{ $roman[$groupIndex] ?? $groupIndex }}</td>
                        <td colspan="16" class="fw-bold">{{ $cat['category_name'] }}</td>
                    </tr>
                    @foreach($cat['items'] as $index => $item)
                        @php
                            $totalHargaLalu = $item['vol_lalu'] * $item['harga_lalu'];
                            $totalHargaMasuk = $item['vol_masuk'] * $item['harga_masuk'];
                            $volJumlah = $item['vol_lalu'] + $item['vol_masuk'];
                            $totalHargaJumlah = $totalHargaLalu + $totalHargaMasuk;
                            $totalHargaKeluar = $item['vol_keluar'] * $item['harga_keluar'];
                            $volSisa = $volJumlah - $item['vol_keluar'];
                            $totalHargaSisa = $totalHargaJumlah - $totalHargaKeluar;
                        @endphp
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td class="fw-medium">{{ $item['name'] }}</td>
                            <td class="text-center">{{ $item['unit'] }}</td>
                            
                            {{-- Sisa Lalu --}}
                            <td class="text-center">{{ $item['vol_lalu'] }}</td>
                            <td class="text-end text-muted">{{ number_format($item['harga_lalu'], 0, ',', '.') }}</td>
                            <td class="text-end text-muted">{{ number_format($totalHargaLalu, 0, ',', '.') }}</td>
                            
                            {{-- Pengadaan --}}
                            <td class="text-center text-success fw-bold">{{ $item['vol_masuk'] }}</td>
                            <td class="text-end text-muted">{{ number_format($item['harga_masuk'], 0, ',', '.') }}</td>
                            <td class="text-end text-muted">{{ number_format($totalHargaMasuk, 0, ',', '.') }}</td>
                            
                            {{-- Jumlah --}}
                            <td class="text-center fw-bold">{{ $volJumlah }}</td>
                            <td class="text-end fw-bold">{{ number_format($totalHargaJumlah, 0, ',', '.') }}</td>
                            
                            {{-- Pemakaian --}}
                            <td class="text-center text-danger fw-bold">{{ $item['vol_keluar'] }}</td>
                            <td class="text-end text-muted">{{ number_format($item['harga_keluar'], 0, ',', '.') }}</td>
                            <td class="text-end text-muted">{{ number_format($totalHargaKeluar, 0, ',', '.') }}</td>
                            
                            {{-- Sisa Akhir --}}
                            <td class="text-center bg-light fw-bold">{{ $volSisa }}</td>
                            <td class="text-end bg-light fw-bold text-primary">{{ number_format($totalHargaSisa, 0, ',', '.') }}</td>
                            
                            {{-- KET --}}
                            <td></td>
                        </tr>
                    @endforeach
                    @php $groupIndex++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg class="mb-3 text-muted opacity-25" style="width:48px;height:48px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z"/></svg>
            <p class="text-muted mb-0">Tidak ada pergerakan barang pada periode ini.</p>
        </div>
        @endif
    </div>
</div>
@endsection
