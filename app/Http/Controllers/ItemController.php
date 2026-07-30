<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with(['category', 'unit']);

        if ($request->has('search') && !empty($request->search)) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('simda_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('category') && $request->category != '') {
            $cat = $request->category;
            if ($cat === 'tetap') {
                $query->whereIn('category_id', [2, 3, 4]);
            } else if ($cat === 'habis_pakai') {
                $query->whereIn('category_id', [1]);
            } else if ($cat === 'benda_pos') {
                $query->whereIn('category_id', [5, 6]);
            } else {
                $query->where('category_id', $cat);
            }
        }

        $items = $query->paginate(10)->appends($request->query());
        $categories = Category::all();
        
        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('items.create', compact('categories', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'simda_code' => 'required|unique:items',
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'unit_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'item_type' => 'required|in:Umum,Elektronik,Kendaraan,Mebeler',
            'purchase_date' => 'nullable|date|required_if:item_type,Elektronik,Kendaraan,Mebeler',
            'last_service_date' => 'nullable|date|required_if:item_type,Kendaraan',
            'tax_month' => 'nullable|integer|min:1|max:12',
            'useful_life' => 'nullable|integer|min:1|required_if:item_type,Elektronik,Kendaraan,Mebeler',
            'residual_value' => 'nullable|numeric|min:0',
            'asset_category' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'register_number' => 'nullable|string|max:255',
            'brand_type' => 'nullable|string|max:255',
            'size_spec' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'factory_number' => 'nullable|string|max:255',
            'chassis_number' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:255',
            'license_plate' => 'nullable|string|max:255',
            'bpkb_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'acquisition_source' => 'nullable|string|max:255',
        ]);

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        $item->load('category', 'unit', 'inventoryTransactions.user');
        $transactions = $item->inventoryTransactions()->orderBy('created_at', 'desc')->paginate(10);
        return view('items.show', compact('item', 'transactions'));
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('items.edit', compact('item', 'categories', 'units'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'simda_code' => 'required|unique:items,simda_code,'.$item->id,
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'unit_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'item_type' => 'required|in:Umum,Elektronik,Kendaraan,Mebeler',
            'purchase_date' => 'nullable|date|required_if:item_type,Elektronik,Kendaraan,Mebeler',
            'last_service_date' => 'nullable|date|required_if:item_type,Kendaraan',
            'tax_month' => 'nullable|integer|min:1|max:12',
            'useful_life' => 'nullable|integer|min:1|required_if:item_type,Elektronik,Kendaraan,Mebeler',
            'residual_value' => 'nullable|numeric|min:0',
            'asset_category' => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'register_number' => 'nullable|string|max:255',
            'brand_type' => 'nullable|string|max:255',
            'size_spec' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'factory_number' => 'nullable|string|max:255',
            'chassis_number' => 'nullable|string|max:255',
            'engine_number' => 'nullable|string|max:255',
            'license_plate' => 'nullable|string|max:255',
            'bpkb_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'acquisition_source' => 'nullable|string|max:255',
        ]);

        $item->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return redirect()->route('items.index')
                ->with('success', 'Barang berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error code 1451 indicates a foreign key constraint violation
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('items.index')
                    ->with('error', 'Barang tidak dapat dihapus karena sudah memiliki riwayat transaksi di gudang.');
            }
            return redirect()->route('items.index')
                ->with('error', 'Terjadi kesalahan pada database saat menghapus barang.');
        }
    }
}
