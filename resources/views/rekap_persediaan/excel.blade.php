<table>
    <thead>
        <tr>
            <th colspan="17" style="text-align: center; font-weight: bold; font-size: 14pt;">REKAPITULASI PERSEDIAAN BARANG PAKAI HABIS</th>
        </tr>
        <tr>
            <th colspan="17" style="text-align: center; font-weight: bold;">Bulan: {{ $queryBulan }}</th>
        </tr>
        <tr>
            <th colspan="17"></th>
        </tr>
        <tr>
            <th rowspan="2" style="font-weight: bold; text-align: center;">NO</th>
            <th rowspan="2" style="font-weight: bold; text-align: center;">NAMA / JENIS BARANG</th>
            <th rowspan="2" style="font-weight: bold; text-align: center;">SATUAN</th>
            <th colspan="3" style="font-weight: bold; text-align: center;">SISA BULAN LALU</th>
            <th colspan="3" style="font-weight: bold; text-align: center;">PENGADAAN BLN INI</th>
            <th colspan="2" style="font-weight: bold; text-align: center;">JUMLAH</th>
            <th colspan="3" style="font-weight: bold; text-align: center;">PEMAKAIAN BLN INI</th>
            <th colspan="2" style="font-weight: bold; text-align: center;">SISA</th>
            <th rowspan="2" style="font-weight: bold; text-align: center;">KET</th>
        </tr>
        <tr>
            <th style="font-weight: bold; text-align: center;">Vol</th>
            <th style="font-weight: bold; text-align: center;">Harga Satuan</th>
            <th style="font-weight: bold; text-align: center;">Jumlah Harga</th>
            <th style="font-weight: bold; text-align: center;">Vol</th>
            <th style="font-weight: bold; text-align: center;">Harga Satuan</th>
            <th style="font-weight: bold; text-align: center;">Jumlah Harga</th>
            <th style="font-weight: bold; text-align: center;">Vol</th>
            <th style="font-weight: bold; text-align: center;">Jumlah Harga</th>
            <th style="font-weight: bold; text-align: center;">Vol</th>
            <th style="font-weight: bold; text-align: center;">Harga Satuan</th>
            <th style="font-weight: bold; text-align: center;">Jumlah Harga</th>
            <th style="font-weight: bold; text-align: center;">Vol</th>
            <th style="font-weight: bold; text-align: center;">Jumlah Harga</th>
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
            
            <tr>
                <td style="font-weight: bold; text-align: center;">{{ $roman[$groupIndex] ?? $groupIndex }}</td>
                <td style="font-weight: bold;">{{ $categoryName }}</td>
                <td colspan="15"></td>
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
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $row->item->name }}</td>
                    <td style="text-align: center;">{{ $row->item->unit->name ?? 'pcs' }}</td>
                    
                    <td style="text-align: center;">{{ $row->sisa_lalu_volume }}</td>
                    <td>{{ $row->sisa_lalu_harga_satuan }}</td>
                    <td>{{ $row->sisa_lalu_total }}</td>
                    
                    <td style="text-align: center;">{{ $row->pengadaan_volume }}</td>
                    <td>{{ $row->pengadaan_harga_satuan }}</td>
                    <td>{{ $row->pengadaan_total }}</td>
                    
                    <td style="text-align: center;">{{ $row->jumlah_volume }}</td>
                    <td>{{ $row->jumlah_harga }}</td>
                    
                    <td style="text-align: center;">{{ $row->pemakaian_volume }}</td>
                    <td>{{ $row->pemakaian_harga_satuan }}</td>
                    <td>{{ $row->pemakaian_total }}</td>
                    
                    <td style="text-align: center;">{{ $row->sisa_volume }}</td>
                    <td>{{ $row->sisa_harga }}</td>
                    
                    <td>{{ $row->keterangan }}</td>
                </tr>
            @endforeach
            
            <tr>
                <td></td>
                <td style="font-weight: bold; text-align: right;">Sub Total {{ $roman[$groupIndex] ?? $groupIndex }} :</td>
                <td></td>
                <td colspan="2"></td>
                <td style="font-weight: bold;">{{ $subTotalSisaLalu }}</td>
                <td colspan="2"></td>
                <td style="font-weight: bold;">{{ $subTotalPengadaan }}</td>
                <td></td>
                <td style="font-weight: bold;">{{ $subTotalJumlah }}</td>
                <td colspan="2"></td>
                <td style="font-weight: bold;">{{ $subTotalPemakaian }}</td>
                <td></td>
                <td style="font-weight: bold;">{{ $subTotalSisaAkhir }}</td>
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
                <td colspan="17" style="text-align: center;">Belum ada data rekapitulasi untuk bulan ini.</td>
            </tr>
        @endforelse
        
        @if($grouped->count() > 0)
        <tr>
            <td></td>
            <td style="font-weight: bold; text-align: right;">TOTAL KESELURUHAN :</td>
            <td></td>
            <td colspan="2"></td>
            <td style="font-weight: bold;">{{ $grandTotalSisaLalu }}</td>
            <td colspan="2"></td>
            <td style="font-weight: bold;">{{ $grandTotalPengadaan }}</td>
            <td></td>
            <td style="font-weight: bold;">{{ $grandTotalJumlah }}</td>
            <td colspan="2"></td>
            <td style="font-weight: bold;">{{ $grandTotalPemakaian }}</td>
            <td></td>
            <td style="font-weight: bold;">{{ $grandTotalSisaAkhir }}</td>
            <td></td>
        </tr>
        @endif
        
        <tr>
            <td colspan="17"></td>
        </tr>
        <tr>
            <td colspan="11"></td>
            <td colspan="6" style="text-align: center;">Tegal, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold;">KEPALA BAGIAN HUKUM</td>
            <td colspan="5"></td>
            <td colspan="6" style="text-align: center; font-weight: bold;">PENGURUS BARANG</td>
        </tr>
        <tr>
            <td colspan="17"></td>
        </tr>
        <tr>
            <td colspan="17"></td>
        </tr>
        <tr>
            <td colspan="17"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; text-decoration: underline;">BUDIO PRADIBTO, SH</td>
            <td colspan="5"></td>
            <td colspan="6" style="text-align: center; font-weight: bold; text-decoration: underline;">PUJI AMBARWATI ,A.Md.T</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center;">NIP 19700705 199003 1 003</td>
            <td colspan="5"></td>
            <td colspan="6" style="text-align: center;">NIP. 19950518 202321 2 031</td>
        </tr>
    </tbody>
</table>
