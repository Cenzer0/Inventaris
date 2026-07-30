<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventoryReportExport implements FromView, ShouldAutoSize
{
    protected $reportData;
    protected $startDate;
    protected $endDate;

    public function __construct($reportData, $startDate, $endDate)
    {
        $this->reportData = $reportData;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        return view('inventory.transactions.report_excel', [
            'reportData' => $this->reportData,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}
