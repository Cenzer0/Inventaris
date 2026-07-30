<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class DepreciationController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query()->whereIn('item_type', ['Elektronik', 'Kendaraan', 'Mebeler']);

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('simda_code', 'like', "%{$search}%");
            });
        }

        // Filter Tipe Barang
        if ($request->filled('type') && in_array($request->type, ['Elektronik', 'Kendaraan', 'Mebeler'])) {
            $query->where('item_type', $request->type);
        }

        // Ambil semua item untuk menghitung total ringkasan statistik (sebelum paginasi)
        $allItems = $query->get();

        $totalPerolehan = 0;
        $totalPenyusutan = 0;
        $totalNilaiBuku = 0;

        foreach ($allItems as $item) {
            $dep = $item->calculateDepreciation();
            $itemTotalPerolehan = $item->unit_price * $item->stock;
            $totalPerolehan += $itemTotalPerolehan;

            if ($dep['depreciable']) {
                $totalPenyusutan += $dep['accumulated_depreciation'] * $item->stock;
                $totalNilaiBuku += $dep['book_value'] * $item->stock;
            } else {
                $totalNilaiBuku += $itemTotalPerolehan;
            }
        }

        // Lakukan paginasi untuk tampilan tabel
        $items = $query->latest()->paginate(10)->withQueryString();

        return view('depreciations.index', compact(
            'items', 
            'totalPerolehan', 
            'totalPenyusutan', 
            'totalNilaiBuku'
        ));
    }
}
