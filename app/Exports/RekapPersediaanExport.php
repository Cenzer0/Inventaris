<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapPersediaanExport implements FromView, ShouldAutoSize
{
    protected $grouped;
    protected $queryBulan;

    public function __construct($grouped, $queryBulan)
    {
        $this->grouped = $grouped;
        $this->queryBulan = $queryBulan;
    }

    public function view(): View
    {
        return view('rekap_persediaan.excel', [
            'grouped' => $this->grouped,
            'queryBulan' => $this->queryBulan,
        ]);
    }
}
