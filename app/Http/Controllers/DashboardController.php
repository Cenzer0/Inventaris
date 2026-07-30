<?php

namespace App\Http\Controllers;

use App\Models\InventoryTransaction;
use App\Models\Item;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Umum
        $totalItems = Item::count();
        $totalStock = Item::sum('stock');
        $lowStockItems = Item::where('stock', '<', 5)->count();
        
        // Item dengan stok rendah
        $lowStockItemsList = Item::where('stock', '<', 5)
            ->with('category', 'unit')
            ->orderBy('stock', 'asc')
            ->get();
        
        // Transaksi terakhir
        $recentTransactions = InventoryTransaction::with('item', 'user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        
        // Kategori terbanyak
        $topCategories = \DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select('categories.name', \DB::raw('COUNT(*) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();
        
        // Nilai total inventaris
        $totalInventoryValue = Item::selectRaw('SUM(stock * unit_price) as total')
            ->first()
            ->total ?? 0;
        
        // Transaksi bulan ini
        $monthlyTransactions = InventoryTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->count();
        
        // Barang masuk/keluar bulan ini
        $monthlyIncoming = InventoryTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->where('transaction_type', 'procurement')
            ->sum('quantity');
        
        $monthlyOutgoing = InventoryTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->where('transaction_type', 'usage')
            ->sum('quantity');

        // Data untuk Grafik Tren Transaksi (bulan ini + 5 bulan ke depan)
        $chartMonths = [];
        $chartIncoming = [];
        $chartOutgoing = [];
        
        for ($i = 1; $i <= now()->month; $i++) {
            $date = now()->month($i);
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

        // Data untuk Grafik Kategori
        $categoryLabels = $topCategories->pluck('name')->toArray();
        $categoryData = $topCategories->pluck('count')->toArray();

        return view('dashboard', compact(
            'totalItems',
            'totalStock',
            'lowStockItems',
            'lowStockItemsList',
            'recentTransactions',
            'topCategories',
            'totalInventoryValue',
            'monthlyTransactions',
            'monthlyIncoming',
            'monthlyOutgoing',
            'chartMonths',
            'chartIncoming',
            'chartOutgoing',
            'categoryLabels',
            'categoryData'
        ));
    }

    /**
     * Return realtime dashboard data as JSON for AJAX polling.
     */
    public function realtimeData()
    {
        // Statistik Umum
        $totalItems = Item::count();
        $totalStock = Item::sum('stock');
        $lowStockItems = Item::where('stock', '<', 5)->count();
        $totalInventoryValue = Item::selectRaw('SUM(stock * unit_price) as total')->first()->total ?? 0;

        // Transaksi bulan ini
        $monthlyTransactions = InventoryTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->count();
        $monthlyIncoming = InventoryTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->where('transaction_type', 'procurement')
            ->sum('quantity');
        $monthlyOutgoing = InventoryTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->where('transaction_type', 'usage')
            ->sum('quantity');

        // Chart data (bulan ini + 5 bulan ke depan)
        $chartMonths = [];
        $chartIncoming = [];
        $chartOutgoing = [];
        for ($i = 1; $i <= now()->month; $i++) {
            $date = now()->month($i);
            $chartMonths[] = $date->translatedFormat('M Y');
            $chartIncoming[] = (int) InventoryTransaction::whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->where('transaction_type', 'procurement')
                ->sum('quantity');
            $chartOutgoing[] = (int) InventoryTransaction::whereMonth('transaction_date', $date->month)
                ->whereYear('transaction_date', $date->year)
                ->where('transaction_type', 'usage')
                ->sum('quantity');
        }

        // Kategori
        $topCategories = \DB::table('items')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->select('categories.name', \DB::raw('COUNT(*) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // Transaksi terbaru
        $recentTransactions = InventoryTransaction::with('item', 'user')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get()
            ->map(function ($trans) {
                return [
                    'item_name' => $trans->item->name ?? '-',
                    'user_name' => explode(' ', $trans->user->name ?? 'Sistem')[0],
                    'type' => $trans->transaction_type,
                    'quantity' => $trans->quantity,
                    'time_ago' => $trans->created_at->diffForHumans(),
                ];
            });

        // Stok rendah
        $lowStockItemsList = Item::where('stock', '<', 5)
            ->with('category', 'unit')
            ->orderBy('stock', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => \Str::limit($item->name, 35),
                    'simda_code' => $item->simda_code,
                    'category_name' => $item->category->name ?? 'Tanpa Kategori',
                    'stock' => $item->stock,
                    'unit_name' => $item->unit->name ?? 'unit',
                ];
            });

        return response()->json([
            'stats' => [
                'totalItems' => number_format($totalItems, 0, ',', '.'),
                'totalStock' => number_format($totalStock, 0, ',', '.'),
                'lowStockItems' => number_format($lowStockItems, 0, ',', '.'),
                'totalInventoryValue' => number_format($totalInventoryValue, 0, ',', '.'),
                'monthlyIncoming' => number_format($monthlyIncoming, 0, ',', '.'),
                'monthlyOutgoing' => number_format($monthlyOutgoing, 0, ',', '.'),
                'monthlyTransactions' => number_format($monthlyTransactions, 0, ',', '.'),
            ],
            'chart' => [
                'months' => $chartMonths,
                'incoming' => $chartIncoming,
                'outgoing' => $chartOutgoing,
            ],
            'category' => [
                'labels' => $topCategories->pluck('name')->toArray(),
                'data' => $topCategories->pluck('count')->toArray(),
            ],
            'recentTransactions' => $recentTransactions,
            'lowStockItemsList' => $lowStockItemsList,
        ]);
    }
}
