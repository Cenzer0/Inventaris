<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function monthlyReport()
    {
        // Default to current month
        $month = request('month', date('m'));
        $year = request('year', date('Y'));

        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Get all items with their beginning stock for the month
        $items = Item::with(['category', 'unit', 'inventoryTransactions' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('transaction_date', [$startDate, $endDate]);
        }])->get();

        // Calculate beginning stock (last month's remaining)
        foreach ($items as $item) {
            $beginningStock = $item->stock;
            $procurement = 0;
            $usage = 0;

            // Calculate procurement and usage for the month
            foreach ($item->inventoryTransactions as $transaction) {
                if ($transaction->transaction_type === 'procurement') {
                    $procurement += $transaction->quantity;
                    $beginningStock -= $transaction->quantity;
                } elseif ($transaction->transaction_type === 'usage') {
                    $usage += $transaction->quantity;
                    $beginningStock += $transaction->quantity;
                }
            }

            $item->beginning_stock = $beginningStock;
            $item->month_procurement = $procurement;
            $item->month_usage = $usage;
            $item->ending_stock = $item->stock;
        }

        // Group by category
        $categories = $items->groupBy('category.name');

        return view('inventory.reports.monthly', compact(
            'categories',
            'month',
            'year'
        ));
    }
}
