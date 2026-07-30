@extends('layouts.app')

@section('title', 'Laporan Bulanan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Laporan Rekapitulasi Bulanan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <form method="GET" action="{{ route('reports.monthly') }}" class="d-flex">
            <select name="month" class="form-select form-select-sm me-2" style="width: auto;">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                    </option>
                @endfor
            </select>
            <select name="year" class="form-select form-select-sm me-2" style="width: auto;">
                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Tampilkan</button>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body text-center">
        <!-- Header Laporan -->
        <h5 class="fw-bold mb-4">REKAPITULASI PERSEDIAAN BARANG PAKAI HABIS</h5>
        <h6 class="mb-4">Bulan : {{ strtoupper(date('F Y', mktime(0, 0, 0, $month, 1, $year))) }}</h6>
        
        @foreach($groupedData as $categoryName => $items)
        <h6 class="mt-4 mb-3 text-start">{{ $categoryName }}</h6>
        <div class="table-responsive">
            <table class="table table-bordered table-sm report-table">
                <thead class="table-light">
                    <tr>
                        <th rowspan="2">No. SIMDA</th>
                        <th rowspan="2">Uraian</th>
                        <th rowspan="2">Satuan</th>
                        <th colspan="3" class="text-center">Sisa Bulan Lalu</th>
                        <th colspan="3" class="text-center">Pengadaan Bulan Ini</th>
                        <th colspan="2" class="text-center">Jumlah</th>
                        <th colspan="3" class="text-center">Pemakaian Bulan Ini</th>
                        <th colspan="2" class="text-center">Sisa</th>
                    </tr>
                    <tr>
                        <th class="text-center">Vol</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Vol</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Vol</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Vol</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Vol</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $data)
                    <tr>
                        <td>{{ $data['item']->simda_code }}</td>
                        <td>{{ $data['item']->name }}</td>
                        <td>{{ $data['item']->unit->name }}</td>
                        <td class="text-end">{{ $data['beginning_stock'] }}</td>
                        <td class="text-end">{{ number_format($data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['beginning_stock'] * $data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ $data['procurement'] }}</td>
                        <td class="text-end">{{ number_format($data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['procurement'] * $data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ $data['beginning_stock'] + $data['procurement'] }}</td>
                        <td class="text-end">{{ number_format(($data['beginning_stock'] + $data['procurement']) * $data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ $data['usage'] }}</td>
                        <td class="text-end">{{ number_format($data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ number_format($data['usage'] * $data['item']->unit_price, 0, ',', '.') }}</td>
                        <td class="text-end">{{ $data['ending_stock'] }}</td>
                        <td class="text-end">{{ number_format($data['ending_stock'] * $data['item']->unit_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
        
        <!-- Tanda Tangan -->
        <div class="mt-5 pt-3 border-top">
            <div class="row">
                <div class="col-md-6 text-start">
                    <p class="mb-1">Mengetahui,</p>
                    <p class="mb-1">KEPALA BAGIAN HUKUM</p>
                    <br><br><br>
                    <p class="mb-0"><u>BUDIO PRADIBTO, SH</u></p>
                    <p class="mb-0">NIP 19700705 199003 1 003</p>
                </div>
                <div class="col-md-6 text-start">
                    <p class="mb-1">{{ date('d F Y') }}</p>
                    <p class="mb-1">Pengurus Barang,</p>
                    <br><br><br>
                    <p class="mb-0"><u>MOHAMAD AMIRUDIN, SH</u></p>
                    <p class="mb-0">NIP 19850910 201001 1 001</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS khusus untuk mencetak -->
<style>
    @media print {
        body { font-size: 10pt; }
        .navbar, .btn-toolbar, .card-header, footer { display: none !important; }
        .report-table th, .report-table td { font-size: 9pt; padding: 4px; }
        .table-responsive { overflow: visible; }
    }
</style>
@endsection