<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Item;
use Illuminate\Http\Request;

class InventoryTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryTransaction::with(['item', 'user'])
            ->orderBy('transaction_date', 'desc');

        if ($request->filled('type')) {
            $type = $request->type == 'in' ? 'procurement' : 'usage';
            $query->where('transaction_type', $type);
        }

        if ($request->filled('startDate')) {
            $query->where('transaction_date', '>=', $request->startDate);
        }

        if ($request->filled('endDate')) {
            $query->where('transaction_date', '<=', $request->endDate);
        }

        $transactions = $query->paginate(10)->withQueryString();

        // Chart Data: monthly from this month to 5 months ahead (6 months total)
        $chartMonths = [];
        $chartIncoming = [];
        $chartOutgoing = [];
        
        for ($i = 0; $i <= 5; $i++) {
            $date = now()->addMonths($i);
            $chartMonths[] = $date->translatedFormat('M Y');
            
            $incoming = InventoryTransaction::whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->where('transaction_type', 'procurement')
                ->sum('quantity');
                
            $outgoing = InventoryTransaction::whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->where('transaction_type', 'usage')
                ->sum('quantity');
                
            $chartIncoming[] = (int)$incoming;
            $chartOutgoing[] = (int)$outgoing;
        }

        return view('inventory.transactions.index', compact(
            'transactions', 
            'chartMonths', 
            'chartIncoming', 
            'chartOutgoing'
        ));
    }

    public function create()
    {
        $items = Item::all();

        return view('inventory.transactions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'transaction_type' => 'required|in:procurement,usage,adjustment',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Auto-fill unit_price from item if not provided
        $item = Item::find($validated['item_id']);
        if (empty($validated['unit_price'])) {
            $validated['unit_price'] = $item->unit_price ?? 0;
        }

        // Pengecekan stok: tidak boleh minus
        if ($request->transaction_type === 'usage' && $request->quantity > $item->stock) {
            return back()
                ->withInput()
                ->withErrors(['quantity' => 'Stok tidak mencukupi. Sisa stok saat ini: ' . $item->stock])
                ->with('error', 'Transaksi tertolak: Jumlah barang keluar (' . $request->quantity . ') melebihi stok yang tersedia (' . $item->stock . ').');
        }

        $validated['user_id'] = auth()->id();
        $transaction = InventoryTransaction::create($validated);

        // Update item stock
        if ($request->transaction_type === 'procurement') {
            $item->stock += $request->quantity;
        } elseif ($request->transaction_type === 'usage') {
            $item->stock -= $request->quantity;
        } elseif ($request->transaction_type === 'adjustment') {
            $item->stock += $request->quantity;
        }
        $item->save();

        // Notify admins and pimpinan
        $admins = \App\Models\User::whereIn('role', ['admin_gudang', 'superadmin', 'pimpinan'])->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\InventoryTransactionNotification($transaction));

        $typeLabel = $request->transaction_type === 'procurement' ? 'Barang Masuk' : 'Barang Keluar';
        return redirect()->route('transactions.index')
            ->with('success', "Transaksi {$typeLabel} berhasil dicatat untuk {$item->name} ({$request->quantity} unit).");
    }

    public function show(InventoryTransaction $transaction)
    {
        return view('inventory.transactions.show', compact('transaction'));
    }

    public function destroy(InventoryTransaction $transaction)
    {
        $item = $transaction->item;
        if ($item) {
            if ($transaction->transaction_type === 'procurement') {
                $item->stock -= $transaction->quantity;
            } elseif ($transaction->transaction_type === 'usage') {
                $item->stock += $transaction->quantity;
            } elseif ($transaction->transaction_type === 'adjustment') {
                $item->stock -= $transaction->quantity;
            }
            $item->save();
        }

        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function report(Request $request)
    {
        $startDate = $request->input('startDate') ? \Carbon\Carbon::parse($request->input('startDate'))->startOfDay() : now()->startOfMonth();
        $endDate = $request->input('endDate') ? \Carbon\Carbon::parse($request->input('endDate'))->endOfDay() : now()->endOfMonth();

        // Get all categories and their items
        $categories = \App\Models\Category::with(['items' => function($query) {
            $query->orderBy('name', 'asc');
        }, 'items.unit'])->orderBy('code', 'asc')->get();

        $reportData = [];

        foreach ($categories as $category) {
            $categoryItems = [];
            foreach ($category->items as $item) {
                // 1. Calculate Sisa Bulan Lalu
                $volInBefore = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->where('transaction_date', '<', $startDate)
                    ->where('transaction_type', 'procurement')
                    ->sum('quantity');
                
                $volOutBefore = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->where('transaction_date', '<', $startDate)
                    ->where('transaction_type', 'usage')
                    ->sum('quantity');
                
                $volLalu = $volInBefore - $volOutBefore;

                // 2. Pengadaan
                $volMasuk = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'procurement')
                    ->sum('quantity');
                
                $priceMasukTrans = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'procurement')
                    ->first();
                $hargaMasuk = $priceMasukTrans ? $priceMasukTrans->unit_price : $item->unit_price;

                // 3. Pemakaian
                $volKeluar = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'usage')
                    ->sum('quantity');

                if ($volLalu > 0 || $volMasuk > 0 || $volKeluar > 0) {
                    $categoryItems[] = [
                        'simda_code' => $item->simda_code,
                        'name' => $item->name,
                        'unit' => $item->unit->name ?? '-',
                        'vol_lalu' => $volLalu,
                        'harga_lalu' => $item->unit_price,
                        'vol_masuk' => $volMasuk,
                        'harga_masuk' => $hargaMasuk,
                        'vol_keluar' => $volKeluar,
                        'harga_keluar' => $item->unit_price,
                    ];
                }
            }

            if (count($categoryItems) > 0) {
                $reportData[] = [
                    'category_code' => $category->code,
                    'category_name' => $category->name,
                    'items' => $categoryItems
                ];
            }
        }

        return view('inventory.transactions.report', compact(
            'reportData',
            'startDate',
            'endDate'
        ));
    }

    // Export PDF
    public function exportPdf(Request $request)
    {
        $startDate = $request->input('startDate') ? \Carbon\Carbon::parse($request->input('startDate'))->startOfDay() : now()->startOfMonth();
        $endDate = $request->input('endDate') ? \Carbon\Carbon::parse($request->input('endDate'))->endOfDay() : now()->endOfMonth();

        // Get all categories and their items
        $categories = \App\Models\Category::with(['items' => function($query) {
            $query->orderBy('name', 'asc');
        }, 'items.unit'])->orderBy('code', 'asc')->get();

        $reportData = [];

        foreach ($categories as $category) {
            $categoryItems = [];
            foreach ($category->items as $item) {
                // 1. Calculate Sisa Bulan Lalu (Balance before startDate)
                // Initial volume = Total IN - Total OUT before startDate
                $volInBefore = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->where('transaction_date', '<', $startDate)
                    ->where('transaction_type', 'procurement')
                    ->sum('quantity');
                
                $volOutBefore = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->where('transaction_date', '<', $startDate)
                    ->where('transaction_type', 'usage')
                    ->sum('quantity');
                
                $volLalu = $volInBefore - $volOutBefore;

                // 2. Pengadaan Bulan Ini (In during range)
                $volMasuk = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'procurement')
                    ->sum('quantity');
                
                // Get procurement price for this period (take the first one or default to item price)
                $priceMasukTrans = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'procurement')
                    ->first();
                $hargaMasuk = $priceMasukTrans ? $priceMasukTrans->unit_price : $item->unit_price;

                // 3. Pemakaian Bulan Ini (Out during range)
                $volKeluar = \App\Models\InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'usage')
                    ->sum('quantity');

                if ($volLalu > 0 || $volMasuk > 0 || $volKeluar > 0) {
                    $categoryItems[] = [
                        'simda_code' => $item->simda_code,
                        'name' => $item->name,
                        'unit' => $item->unit->name ?? '-',
                        'vol_lalu' => $volLalu,
                        'harga_lalu' => $item->unit_price, // Base price for initial balance
                        'vol_masuk' => $volMasuk,
                        'harga_masuk' => $hargaMasuk,
                        'vol_keluar' => $volKeluar,
                        'harga_keluar' => $item->unit_price, // Usually uses base price or average
                    ];
                }
            }

            if (count($categoryItems) > 0) {
                $reportData[] = [
                    'category_code' => $category->code,
                    'category_name' => $category->name,
                    'items' => $categoryItems
                ];
            }
        }

        $pdf = \PDF::loadView('inventory.transactions.report_pdf', [
            'reportData' => $reportData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->setPaper('legal', 'landscape');

        $fileName = 'rekap-persediaan-' . $startDate->format('M-Y') . '.pdf';
        return $pdf->download($fileName);
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        $startDate = $request->input('startDate') ? \Carbon\Carbon::parse($request->input('startDate'))->startOfDay() : now()->startOfMonth();
        $endDate = $request->input('endDate') ? \Carbon\Carbon::parse($request->input('endDate'))->endOfDay() : now()->endOfMonth();

        // Same aggregation logic as PDF
        $categories = \App\Models\Category::with(['items' => function($query) {
            $query->orderBy('name', 'asc');
        }, 'items.unit'])->orderBy('code', 'asc')->get();

        $reportData = [];

        foreach ($categories as $category) {
            $categoryItems = [];
            foreach ($category->items as $item) {
                $volInBefore = InventoryTransaction::where('item_id', $item->id)
                    ->where('transaction_date', '<', $startDate)
                    ->where('transaction_type', 'procurement')
                    ->sum('quantity');
                
                $volOutBefore = InventoryTransaction::where('item_id', $item->id)
                    ->where('transaction_date', '<', $startDate)
                    ->where('transaction_type', 'usage')
                    ->sum('quantity');
                
                $volLalu = $volInBefore - $volOutBefore;

                $volMasuk = InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'procurement')
                    ->sum('quantity');
                
                $priceMasukTrans = InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'procurement')
                    ->first();
                $hargaMasuk = $priceMasukTrans ? $priceMasukTrans->unit_price : $item->unit_price;

                $volKeluar = InventoryTransaction::where('item_id', $item->id)
                    ->whereBetween('transaction_date', [$startDate, $endDate])
                    ->where('transaction_type', 'usage')
                    ->sum('quantity');

                if ($volLalu > 0 || $volMasuk > 0 || $volKeluar > 0) {
                    $categoryItems[] = [
                        'simda_code' => $item->simda_code,
                        'name' => $item->name,
                        'unit' => $item->unit->name ?? '-',
                        'vol_lalu' => $volLalu,
                        'harga_lalu' => $item->unit_price,
                        'vol_masuk' => $volMasuk,
                        'harga_masuk' => $hargaMasuk,
                        'vol_keluar' => $volKeluar,
                        'harga_keluar' => $item->unit_price,
                    ];
                }
            }

            if (count($categoryItems) > 0) {
                $reportData[] = [
                    'category_code' => $category->code,
                    'category_name' => $category->name,
                    'items' => $categoryItems
                ];
            }
        }

        $export = new \App\Exports\InventoryReportExport($reportData, $startDate, $endDate);
        $fileName = 'rekap-persediaan-' . $startDate->format('M-Y') . '.xlsx';
        return \Excel::download($export, $fileName);
    }
}
