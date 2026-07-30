<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'simda_code', 'name', 'description', 'category_id',
        'unit_id', 'unit_price', 'stock', 'item_type',
        'purchase_date', 'last_service_date', 'tax_month',
        'useful_life', 'residual_value',
        'asset_category', 'registration_number', 'register_number',
        'brand_type', 'size_spec', 'material', 'factory_number',
        'chassis_number', 'engine_number', 'license_plate',
        'bpkb_number', 'location', 'acquisition_source'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'last_service_date' => 'date',
    ];

    /**
     * Daftar nama bulan dalam Bahasa Indonesia.
     */
    public const MONTH_NAMES = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    /**
     * Mendapatkan nama bulan pajak.
     */
    public function getTaxMonthNameAttribute(): ?string
    {
        if (!$this->tax_month) return null;
        return self::MONTH_NAMES[$this->tax_month] ?? null;
    }

    /**
     * Cek apakah tipe barang memiliki sistem penyusutan.
     */
    public function isDepreciable(): bool
    {
        return in_array($this->item_type, ['Elektronik', 'Kendaraan', 'Mebeler']);
    }

    /**
     * Dapatkan standar masa manfaat (dalam tahun) berdasarkan tipe barang (Mengacu pada standar umum pemda/BMN).
     * Elektronik = 4 tahun
     * Mebeler = 5 tahun
     * Kendaraan = 7 tahun
     * Lainnya = 0
     */
    public function getStandardUsefulLife(): int
    {
        switch ($this->item_type) {
            case 'Elektronik':
                return 4;
            case 'Mebeler':
                return 5;
            case 'Kendaraan':
                return 7;
            default:
                return 0;
        }
    }

    /**
     * Cek apakah item ini menggunakan masa manfaat standar (otomatis) karena tidak diisi manual.
     */
    public function isUsingStandardUsefulLife(): bool
    {
        return empty($this->useful_life) || $this->useful_life <= 0;
    }

    /**
     * Hitung data penyusutan barang (Straight-Line Method / Garis Lurus).
     */
    public function calculateDepreciation(): array
    {
        if (!$this->isDepreciable() || !$this->purchase_date) {
            return [
                'depreciable' => false,
                'monthly_depreciation' => 0,
                'annual_depreciation' => 0,
                'months_elapsed' => 0,
                'accumulated_depreciation' => 0,
                'book_value' => (float) $this->unit_price,
                'is_fully_depreciated' => false,
            ];
        }

        $hargaPerolehan = (float) $this->unit_price;
        $nilaiResidu = (float) ($this->residual_value ?? 0);
        $masaManfaatTahun = (int) ($this->useful_life ?? $this->getStandardUsefulLife());
        $masaManfaatBulan = $masaManfaatTahun * 12;

        if ($masaManfaatTahun <= 0) {
            return [
                'depreciable' => false,
                'monthly_depreciation' => 0,
                'annual_depreciation' => 0,
                'months_elapsed' => 0,
                'accumulated_depreciation' => 0,
                'book_value' => $hargaPerolehan,
                'is_fully_depreciated' => false,
            ];
        }

        $depreciableAmount = $hargaPerolehan - $nilaiResidu;
        if ($depreciableAmount < 0) {
            $depreciableAmount = 0;
        }

        $penyusutanTahunan = $depreciableAmount / $masaManfaatTahun;
        $penyusutanBulanan = $depreciableAmount / $masaManfaatBulan;

        $tanggalBeli = \Carbon\Carbon::parse($this->purchase_date)->startOfDay();
        $sekarang = \Carbon\Carbon::now()->startOfDay();

        if ($sekarang->lessThan($tanggalBeli)) {
            $bulanBerjalan = 0;
        } else {
            // Hitung selisih bulan secara akurat
            $bulanBerjalan = $tanggalBeli->diffInMonths($sekarang);
        }

        if ($bulanBerjalan >= $masaManfaatBulan) {
            $bulanBerjalan = $masaManfaatBulan;
            $akumulasiPenyusutan = $depreciableAmount;
            $nilaiBuku = $nilaiResidu;
        } else {
            $akumulasiPenyusutan = $penyusutanBulanan * $bulanBerjalan;
            $nilaiBuku = $hargaPerolehan - $akumulasiPenyusutan;
        }

        return [
            'depreciable' => true,
            'monthly_depreciation' => $penyusutanBulanan,
            'annual_depreciation' => $penyusutanTahunan,
            'months_elapsed' => $bulanBerjalan,
            'accumulated_depreciation' => $akumulasiPenyusutan,
            'book_value' => $nilaiBuku,
            'is_fully_depreciated' => $bulanBerjalan >= $masaManfaatBulan,
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}

