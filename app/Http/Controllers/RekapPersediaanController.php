<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekapPersediaan;
use App\Models\Category;

class RekapPersediaanController extends Controller
{
    public function index(Request $request)
    {
        $inputBulan = $request->query('bulan', date('Y-m')); // Default to current month e.g. 2026-07
        $queryBulan = $inputBulan;

        // If format is YYYY-MM, translate to Indonesian string like "Mei 2026"
        if (preg_match('/^\d{4}-\d{2}$/', $inputBulan)) {
            \Carbon\Carbon::setLocale('id');
            $queryBulan = \Carbon\Carbon::parse($inputBulan)->translatedFormat('F Y');
        } elseif ($inputBulan == 'Mei 2026') {
            // Fallback for old default if someone explicitly types it or if it's empty in a weird way
            $queryBulan = 'Mei 2026';
            $inputBulan = '2026-05'; // For the HTML input
        }

        $rekaps = RekapPersediaan::with('item.category', 'item.unit')
            ->where('bulan', $queryBulan)
            ->get();

        // Group by category based on SIMDA requirement
        $grouped = $rekaps->groupBy(function($item) {
            return $item->item->category->name ?? 'Lainnya';
        });

        // Pass $inputBulan for the input field value, and $queryBulan just in case
        return view('rekap_persediaan.index', compact('grouped', 'inputBulan', 'queryBulan'));
    }

    public function exportPdf(Request $request)
    {
        $inputBulan = $request->query('bulan', date('Y-m'));
        $queryBulan = $inputBulan;

        if (preg_match('/^\d{4}-\d{2}$/', $inputBulan)) {
            \Carbon\Carbon::setLocale('id');
            $queryBulan = \Carbon\Carbon::parse($inputBulan)->translatedFormat('F Y');
        } elseif ($inputBulan == 'Mei 2026') {
            $queryBulan = 'Mei 2026';
        }

        $rekaps = RekapPersediaan::with('item.category', 'item.unit')
            ->where('bulan', $queryBulan)
            ->get();

        $grouped = $rekaps->groupBy(function($item) {
            return $item->item->category->name ?? 'Lainnya';
        });

        $pdf = \PDF::loadView('rekap_persediaan.pdf', compact('grouped', 'queryBulan'))
                    ->setPaper('legal', 'landscape');
                    
        $fileName = 'Rekap_Persediaan_' . str_replace(' ', '_', $queryBulan) . '.pdf';
        return $pdf->download($fileName);
    }

    public function exportExcel(Request $request)
    {
        $inputBulan = $request->query('bulan', date('Y-m'));
        $queryBulan = $inputBulan;

        if (preg_match('/^\d{4}-\d{2}$/', $inputBulan)) {
            \Carbon\Carbon::setLocale('id');
            $queryBulan = \Carbon\Carbon::parse($inputBulan)->translatedFormat('F Y');
        } elseif ($inputBulan == 'Mei 2026') {
            $queryBulan = 'Mei 2026';
        }

        $rekaps = RekapPersediaan::with('item.category', 'item.unit')
            ->where('bulan', $queryBulan)
            ->get();

        $grouped = $rekaps->groupBy(function($item) {
            return $item->item->category->name ?? 'Lainnya';
        });

        $fileName = 'Rekap_Persediaan_' . str_replace(' ', '_', $queryBulan) . '.xlsx';
        return \Excel::download(new \App\Exports\RekapPersediaanExport($grouped, $queryBulan), $fileName);
    }
}
