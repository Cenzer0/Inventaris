<table>
    <tr>
        <td colspan="17" style="font-size:14px; font-weight:bold; text-align:center; height: 30px; vertical-align: middle;">
            REKAPITULASI PERSEDIAAN BARANG PAKAI HABIS
        </td>
    </tr>
    <tr>
        <td colspan="17" style="font-size:12px; font-weight:bold; text-align:center; height: 25px; vertical-align: middle;">
            SKPD : Bagian Hukum
        </td>
    </tr>
    <tr>
        <td colspan="17" style="font-size:12px; font-weight:bold; text-align:center; height: 25px; vertical-align: middle;">
            Bulan : {{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }}
        </td>
    </tr>
    <tr><td colspan="17"></td></tr>

    {{-- Header Row 1 --}}
    <tr>
        <th rowspan="2" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000; vertical-align:middle;">No.<br>SIMDA</th>
        <th rowspan="2" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000; vertical-align:middle;">Uraian</th>
        <th rowspan="2" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000; vertical-align:middle;">Satuan</th>
        <th colspan="3" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Sisa Bulan Lalu ({{ \Carbon\Carbon::parse($startDate)->subMonth()->translatedFormat('F') }})</th>
        <th colspan="3" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Pengadaan Bulan {{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }}</th>
        <th colspan="2" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Jumlah</th>
        <th colspan="3" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Pemakaian Bulan {{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }}</th>
        <th colspan="2" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Sisa</th>
        <th rowspan="2" style="background-color:#0f3b73; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000; vertical-align:middle;">Ket</th>
    </tr>
    {{-- Header Row 2 --}}
    <tr>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Volume</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Harga Satuan</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Total Harga</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Volume</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Harga Satuan</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Total Harga</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Volume (4+7)</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Harga (6+9)</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Volume</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Harga Satuan</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Total Harga</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Volume (10-12)</th>
        <th style="background-color:#1a5276; color:#ffffff; font-weight:bold; text-align:center; border:1px solid #000000;">Harga (11-14)</th>
    </tr>
    {{-- Column Numbers Row --}}
    <tr>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">1</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">2</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">3</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">4</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">5</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">6</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">7</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">8</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">9</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">10</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">11</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">12</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">13</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">14</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">15</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">16</th>
        <th style="background-color:#e2e8f0; font-weight:bold; text-align:center; border:1px solid #000000;">17</th>
    </tr>

    {{-- Data Rows --}}
    @foreach($reportData as $cat)
    <tr>
        <td style="font-weight:bold; background-color:#f0f0f0; border:1px solid #000000;">{{ $cat['category_code'] }}</td>
        <td colspan="16" style="font-weight:bold; background-color:#f0f0f0; border:1px solid #000000;">{{ $cat['category_name'] }}</td>
    </tr>
    @foreach($cat['items'] as $item)
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
            <td style="border:1px solid #000000; text-align:center;">{{ $item['simda_code'] }}</td>
            <td style="border:1px solid #000000;">{{ $item['name'] }}</td>
            <td style="border:1px solid #000000; text-align:center;">{{ $item['unit'] }}</td>
            
            {{-- Sisa Lalu --}}
            <td style="border:1px solid #000000; text-align:center;">{{ $item['vol_lalu'] }}</td>
            <td style="border:1px solid #000000; text-align:right;">{{ number_format($item['harga_lalu'], 0, ',', '.') }}</td>
            <td style="border:1px solid #000000; text-align:right;">{{ number_format($totalHargaLalu, 0, ',', '.') }}</td>
            
            {{-- Pengadaan --}}
            <td style="border:1px solid #000000; text-align:center; color:#059669; font-weight:bold;">{{ $item['vol_masuk'] }}</td>
            <td style="border:1px solid #000000; text-align:right;">{{ number_format($item['harga_masuk'], 0, ',', '.') }}</td>
            <td style="border:1px solid #000000; text-align:right;">{{ number_format($totalHargaMasuk, 0, ',', '.') }}</td>
            
            {{-- Jumlah --}}
            <td style="border:1px solid #000000; text-align:center; font-weight:bold;">{{ $volJumlah }}</td>
            <td style="border:1px solid #000000; text-align:right; font-weight:bold;">{{ number_format($totalHargaJumlah, 0, ',', '.') }}</td>
            
            {{-- Pemakaian --}}
            <td style="border:1px solid #000000; text-align:center; color:#dc2626; font-weight:bold;">{{ $item['vol_keluar'] }}</td>
            <td style="border:1px solid #000000; text-align:right;">{{ number_format($item['harga_keluar'], 0, ',', '.') }}</td>
            <td style="border:1px solid #000000; text-align:right;">{{ number_format($totalHargaKeluar, 0, ',', '.') }}</td>
            
            {{-- Sisa --}}
            <td style="border:1px solid #000000; text-align:center; font-weight:bold;">{{ $volSisa }}</td>
            <td style="border:1px solid #000000; text-align:right; font-weight:bold;">{{ number_format($totalHargaSisa, 0, ',', '.') }}</td>
            
            <td style="border:1px solid #000000;"></td>
        </tr>
    @endforeach
    @endforeach
</table>
