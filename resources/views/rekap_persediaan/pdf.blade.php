<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Persediaan Barang Pakai Habis</title>
    <style>
        @page { margin: 0.5cm; }
        body { font-family: 'Arial', sans-serif; font-size: 8pt; margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h3 { margin: 0; text-transform: uppercase; font-size: 11pt; }
        .header p { margin: 2px 0; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid black; padding: 2px 4px; word-wrap: break-word; }
        th { background-color: #f2f2f2; text-align: center; font-weight: bold; vertical-align: middle; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-gray { background-color: #f9f9f9; }
        .col-num { width: 30px; }
        .col-price { width: 50px; }
        .col-total { width: 65px; }
        .category-row { font-weight: bold; background-color: #e8e8e8; }
    </style>
</head>
<body>
    <div class="header">
        <h3>REKAPITULASI PERSEDIAAN BARANG PAKAI HABIS</h3>
        <p>Bulan : {{ $queryBulan }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 30px;">NO</th>
                <th rowspan="2" style="width: 150px;">NAMA / JENIS BARANG</th>
                <th rowspan="2" style="width: 40px;">SATUAN</th>
                <th colspan="3">SISA BULAN LALU</th>
                <th colspan="3">PENGADAAN BLN INI</th>
                <th colspan="2">JUMLAH</th>
                <th colspan="3">PEMAKAIAN BLN INI</th>
                <th colspan="2">SISA</th>
                <th rowspan="2" style="width: 30px;">Ket</th>
            </tr>
            <tr>
                <th class="col-num">Vol</th>
                <th class="col-price">Harga Satuan</th>
                <th class="col-total">Jumlah Harga</th>
                <th class="col-num">Vol</th>
                <th class="col-price">Harga Satuan</th>
                <th class="col-total">Jumlah Harga</th>
                <th class="col-num">Vol</th>
                <th class="col-total">Jumlah Harga</th>
                <th class="col-num">Vol</th>
                <th class="col-price">Harga Satuan</th>
                <th class="col-total">Jumlah Harga</th>
                <th class="col-num">Vol</th>
                <th class="col-total">Jumlah Harga</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotalSisaLalu = 0;
                $grandTotalPengadaan = 0;
                $grandTotalJumlah = 0;
                $grandTotalPemakaian = 0;
                $grandTotalSisaAkhir = 0;
                
                $roman = ['1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV', '5' => 'V', '6' => 'VI', '7' => 'VII', '8' => 'VIII', '9' => 'IX', '10' => 'X'];
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
                <tr class="category-row">
                    <td class="text-center">{{ $roman[$groupIndex] ?? $groupIndex }}</td>
                    <td colspan="16">{{ $categoryName }}</td>
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
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $row->item->name }}</td>
                        <td class="text-center">{{ $row->item->unit->name ?? 'pcs' }}</td>
                        
                        <td class="text-center">{{ $row->sisa_lalu_volume }}</td>
                        <td class="text-right">{{ number_format($row->sisa_lalu_harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($row->sisa_lalu_total, 0, ',', '.') }}</td>
                        
                        <td class="text-center">{{ $row->pengadaan_volume }}</td>
                        <td class="text-right">{{ number_format($row->pengadaan_harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($row->pengadaan_total, 0, ',', '.') }}</td>
                        
                        <td class="text-center">{{ $row->jumlah_volume }}</td>
                        <td class="text-right">{{ number_format($row->jumlah_harga, 0, ',', '.') }}</td>
                        
                        <td class="text-center">{{ $row->pemakaian_volume }}</td>
                        <td class="text-right">{{ number_format($row->pemakaian_harga_satuan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($row->pemakaian_total, 0, ',', '.') }}</td>
                        
                        <td class="text-center">{{ $row->sisa_volume }}</td>
                        <td class="text-right">{{ number_format($row->sisa_harga, 0, ',', '.') }}</td>
                        
                        <td>{{ $row->keterangan }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td></td>
                    <td class="text-right">Sub Total {{ $roman[$groupIndex] ?? $groupIndex }} :</td>
                    <td></td>
                    <td colspan="2"></td>
                    <td class="text-right">{{ number_format($subTotalSisaLalu, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                    <td class="text-right">{{ number_format($subTotalPengadaan, 0, ',', '.') }}</td>
                    <td></td>
                    <td class="text-right">{{ number_format($subTotalJumlah, 0, ',', '.') }}</td>
                    <td colspan="2"></td>
                    <td class="text-right">{{ number_format($subTotalPemakaian, 0, ',', '.') }}</td>
                    <td></td>
                    <td class="text-right">{{ number_format($subTotalSisaAkhir, 0, ',', '.') }}</td>
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
                <tr><td colspan="17" class="text-center">Belum ada data rekapitulasi untuk bulan ini.</td></tr>
            @endforelse
            
            @if($grouped->count() > 0)
            <tr style="background-color: #e0e0e0; font-weight: bold;">
                <td></td>
                <td class="text-right">TOTAL KESELURUHAN :</td>
                <td></td>
                <td colspan="2"></td>
                <td class="text-right">{{ number_format($grandTotalSisaLalu, 0, ',', '.') }}</td>
                <td colspan="2"></td>
                <td class="text-right">{{ number_format($grandTotalPengadaan, 0, ',', '.') }}</td>
                <td></td>
                <td class="text-right">{{ number_format($grandTotalJumlah, 0, ',', '.') }}</td>
                <td colspan="2"></td>
                <td class="text-right">{{ number_format($grandTotalPemakaian, 0, ',', '.') }}</td>
                <td></td>
                <td class="text-right">{{ number_format($grandTotalSisaAkhir, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            @endif
        </tbody>
    </table>
    
    <div style="margin-top: 30px; width: 100%;">
        <table style="border: none !important;">
            <tr style="border: none !important;">
                <td style="border: none !important; width: 50%; text-align: center;">
                    <br>
                    <strong>KEPALA BAGIAN HUKUM</strong>
                    <br><br><br><br><br>
                    <strong style="text-decoration: underline;">BUDIO PRADIBTO, SH</strong><br>
                    NIP 19700705 199003 1 003
                </td>
                <td style="border: none !important; width: 50%; text-align: center;">
                    Tegal, {{ date('d F Y') }}<br>
                    <strong>PENGURUS BARANG</strong>
                    <br><br><br><br><br>
                    <strong style="text-decoration: underline;">PUJI AMBARWATI ,A.Md.T</strong><br>
                    NIP. 19950518 202321 2 031
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
