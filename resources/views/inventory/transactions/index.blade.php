@extends('layouts.app')

@section('title', 'Transaksi Inventaris')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-1 d-flex align-items-center">
            <svg class="text-primary me-2 flex-shrink-0" style="width:28px;height:28px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Transaksi Inventaris
        </h4>
        <p class="text-muted small mb-0">Riwayat pencatatan barang masuk dan keluar</p>
    </div>
    <div class="mt-3 mt-md-0">
        <a href="{{ route('transactions.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">
            <svg class="me-1" style="width:18px;height:18px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Catat Transaksi
        </a>
    </div>
</div>

{{-- Bar Chart --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-start">
        <div>
            <h5 class="fw-bold mb-1 text-dark">Grafik Transaksi</h5>
            <p class="text-muted small mb-0">Arus barang masuk dan keluar dari bulan ini hingga 6 bulan ke depan</p>
        </div>
        <div class="icon-box bg-light text-muted p-2 rounded-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
            </svg>
        </div>
    </div>
    <div class="card-body bg-white px-4 pb-4 pt-2">
        <div id="transactionBarChart" style="min-height: 350px;"></div>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius:14px">
    <div class="card-body py-3 px-4">
        <form method="GET" action="{{ route('transactions.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-semibold text-muted mb-1">Tipe Transaksi</label>
                <select class="form-select" style="border-radius:10px;height:42px" name="type">
                    <option value="">Semua Tipe</option>
                    <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Dari Tanggal</label>
                <input type="date" class="form-control" style="border-radius:10px;height:42px" name="startDate" value="{{ request('startDate') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold text-muted mb-1">Sampai Tanggal</label>
                <input type="date" class="form-control" style="border-radius:10px;height:42px" name="endDate" value="{{ request('endDate') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;height:42px">
                    <svg class="me-1" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/></svg>
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Data Table --}}
<div class="card border-0 shadow-sm" style="border-radius:14px">
    <div class="card-body p-0">
        @if($transactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size:0.875rem">
                <thead>
                    <tr style="background:#f8fafc">
                        <th class="text-muted fw-semibold px-4 py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">TANGGAL</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">BARANG</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">TIPE</th>
                        <th class="text-muted fw-semibold py-3 border-0 text-center" style="font-size:0.75rem;letter-spacing:0.5px">JUMLAH</th>
                        <th class="text-muted fw-semibold py-3 border-0" style="font-size:0.75rem;letter-spacing:0.5px">PENCATAT</th>
                        <th class="text-muted fw-semibold px-4 py-3 border-0 text-end" style="font-size:0.75rem;letter-spacing:0.5px">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trans)
                    <tr>
                        <td class="px-4 py-3 text-nowrap">
                            {{ $trans->created_at->format('d M Y') }}<br>
                            <span class="text-muted" style="font-size:0.75rem">{{ $trans->created_at->format('H:i') }}</span>
                        </td>
                        <td class="py-3">
                            <div class="fw-medium">{{ Str::limit($trans->item->name, 35) }}</div>
                            <div class="d-flex align-items-center mt-1">
                                <code class="bg-light rounded px-2 py-0 me-2" style="font-size:0.75rem">{{ $trans->item->simda_code }}</code>
                                <span class="text-muted small">{{ $trans->item->category->name }}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            @if($trans->transaction_type === 'procurement')
                                <span class="badge rounded-pill px-3 py-2" style="background:rgba(16,185,129,0.1);color:#059669">
                                    <svg class="me-1" style="width:12px;height:12px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    Masuk
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2" style="background:rgba(239,68,68,0.1);color:#dc2626">
                                    <svg class="me-1" style="width:12px;height:12px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-center fw-bold">{{ $trans->quantity }}</td>
                        <td class="py-3 text-muted">{{ explode(' ', $trans->user->name ?? '-')[0] }}</td>
                        <td class="px-4 py-3 text-end">
                            <a href="{{ route('transactions.show', $trans) }}" class="btn btn-sm btn-light rounded-2 me-1" title="Lihat" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                <svg class="text-info" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </a>
                            <form action="{{ route('transactions.destroy', $trans) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light rounded-2 text-danger" onclick="return confirm('Yakin ingin menghapus? Stok akan dikembalikan.')" title="Hapus" style="width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center">
                                    <svg style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 d-flex justify-content-center">
            {{ $transactions->links('pagination::bootstrap-5') }}
        </div>
        @else
        <div class="text-center py-5">
            <svg class="text-muted opacity-25 mb-3" style="width:48px;height:48px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            <p class="text-muted mb-3">Belum ada transaksi.</p>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius:10px">Catat Transaksi Pertama</a>
        </div>
        @endif
    </div>
</div>
</div>

<!-- ApexCharts Script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(typeof ApexCharts === 'undefined') return;

        var options = {
            series: [{
                name: 'Barang Masuk',
                data: {!! json_encode($chartIncoming ?? []) !!}
            }, {
                name: 'Barang Keluar',
                data: {!! json_encode($chartOutgoing ?? []) !!}
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                fontFamily: 'Inter, system-ui, sans-serif',
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            colors: ['#10b981', '#ef4444'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    borderRadius: 4
                },
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: {!! json_encode($chartMonths ?? []) !!},
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#64748b', fontWeight: 500 } }
            },
            yaxis: {
                labels: { style: { colors: '#64748b', fontWeight: 500 } }
            },
            fill: { opacity: 1 },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return val + " unit"
                    }
                }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            legend: { position: 'top', horizontalAlign: 'right', markers: { radius: 12 }, itemMargin: { horizontal: 10 } }
        };

        var chart = new ApexCharts(document.querySelector("#transactionBarChart"), options);
        chart.render();
    });
</script>
@endsection
