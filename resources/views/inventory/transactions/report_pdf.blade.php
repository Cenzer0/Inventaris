<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Persediaan Barang Pakai Habis</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 8pt;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 11pt;
        }
        .header p {
            margin: 2px 0;
            font-size: 10pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid black;
            padding: 2px 4px;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-gray { background-color: #f9f9f9; }
        
        /* Column Widths */
        .col-simda { width: 40px; }
        .col-uraian { width: 140px; }
        .col-satuan { width: 35px; }
        .col-num { width: 30px; } /* for Volume */
        .col-price { width: 50px; } /* for Price */
        .col-total { width: 65px; } /* for Total Price */
        .col-ket { width: 30px; }

        .subtotal-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .category-row {
            font-weight: bold;
            background-color: #e8e8e8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>REKAPITULASI PERSEDIAAN BARANG PAKAI HABIS</h3>
        <p>SKPD : Bagian Hukum</p>
        <p>Bulan : {{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="col-simda">No. SIMDA</th>
                <th rowspan="2" class="col-uraian">Uraian</th>
                <th rowspan="2" class="col-satuan">Satuan</th>
                <th colspan="3">Sisa Bulan Lalu ({{ \Carbon\Carbon::parse($startDate)->subMonth()->translatedFormat('F') }})</th>
                <th colspan="3">Pengadaan Bulan {{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }}</th>
                <th colspan="2">Jumlah</th>
                <th colspan="3">Pemakaian Bulan {{ \Carbon\Carbon::parse($startDate)->translatedFormat('F Y') }}</th>
                <th colspan="2">Sisa</th>
                <th rowspan="2" class="col-ket">Ket</th>
            </tr>
            <tr>
                <!-- Sisa Lalu -->
                <th class="col-num">Volume</th>
                <th class="col-price">Harga Satuan</th>
                <th class="col-total">Total Harga</th>
                <!-- Pengadaan -->
                <th class="col-num">Volume</th>
                <th class="col-price">Harga Satuan</th>
                <th class="col-total">Total Harga</th>
                <!-- Jumlah -->
                <th class="col-num">Volume<br>(4+7)</th>
                <th class="col-total">Harga<br>(6+9)</th>
                <!-- Pemakaian -->
                <th class="col-num">Volume</th>
                <th class="col-price">Harga Satuan</th>
                <th class="col-total">Total Harga</th>
                <!-- Sisa -->
                <th class="col-num">Volume<br>(10-12)</th>
                <th class="col-total">Harga<br>(11-14)</th>
            </tr>
            <tr class="bg-gray">
                <th style="font-size: 7pt;">1</th>
                <th style="font-size: 7pt;">2</th>
                <th style="font-size: 7pt;">3</th>
                <th style="font-size: 7pt;">4</th>
                <th style="font-size: 7pt;">5</th>
                <th style="font-size: 7pt;">6</th>
                <th style="font-size: 7pt;">7</th>
                <th style="font-size: 7pt;">8</th>
                <th style="font-size: 7pt;">9</th>
                <th style="font-size: 7pt;">10</th>
                <th style="font-size: 7pt;">11</th>
                <th style="font-size: 7pt;">12</th>
                <th style="font-size: 7pt;">13</th>
                <th style="font-size: 7pt;">14</th>
                <th style="font-size: 7pt;">15</th>
                <th style="font-size: 7pt;">16</th>
                <th style="font-size: 7pt;">17</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $cat)
                <tr class="category-row">
                    <td>{{ $cat['category_code'] }}</td>
                    <td colspan="16">{{ $cat['category_name'] }}</td>
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
                        <td class="text-center">{{ $item['simda_code'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td class="text-center">{{ $item['unit'] }}</td>
                        
                        <!-- Sisa Lalu -->
                        <td class="text-center">{{ $item['vol_lalu'] ?: '0' }}</td>
                        <td class="text-right">{{ number_format($item['harga_lalu'], 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($totalHargaLalu, 0, ',', '.') }}</td>
                        
                        <!-- Pengadaan -->
                        <td class="text-center">{{ $item['vol_masuk'] ?: '0' }}</td>
                        <td class="text-right">{{ number_format($item['harga_masuk'], 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($totalHargaMasuk, 0, ',', '.') }}</td>
                        
                        <!-- Jumlah -->
                        <td class="text-center">{{ $volJumlah ?: '0' }}</td>
                        <td class="text-right">{{ number_format($totalHargaJumlah, 0, ',', '.') }}</td>
                        
                        <!-- Pemakaian -->
                        <td class="text-center">{{ $item['vol_keluar'] ?: '0' }}</td>
                        <td class="text-right">{{ number_format($item['harga_keluar'], 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($totalHargaKeluar, 0, ',', '.') }}</td>
                        
                        <!-- Sisa -->
                        <td class="text-center">{{ $volSisa ?: '0' }}</td>
                        <td class="text-right">{{ number_format($totalHargaSisa, 0, ',', '.') }}</td>
                        
                        <td class="text-center"></td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; width: 100%;">
        <table style="border: none !important;">
            <tr style="border: none !important;">
                <td style="border: none !important; width: 70%;"></td>
                <td style="border: none !important; text-align: center;">
                    Tegal, {{ now()->translatedFormat('d F Y') }}<br>
                    <strong>Kepala Bagian Hukum</strong>
                    <br><br><br><br>
                    <strong>( ___________________________ )</strong><br>
                    NIP. .....................................
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
