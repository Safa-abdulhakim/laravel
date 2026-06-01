<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', '30');

        $totalSales = Sale::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays($period))
            ->sum('total');

        $totalProfit = Sale::with('items.product')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays($period))
            ->get()
            ->sum(function ($sale) {
                return $sale->items->sum(function ($item) {
                    $cost = $item->product->cost_price ?? 0;
                    return ($item->unit_price - $cost) * $item->quantity;
                });
            });

        $totalOrders = Sale::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays($period))
            ->count();

        $totalCustomers = Customer::count();
        $totalProducts = Product::where('status', 'active')->count();

        $lowStockProducts = Product::where('status', '!=', 'out_of_stock')
            ->whereRaw('quantity <= low_stock_threshold')
            ->with('category')
            ->get();

        $outOfStockProducts = Product::where('quantity', '<=', 0)->count();

        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.status', 'completed')
            ->where('sales.created_at', '>=', now()->subDays($period))
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_qty'),
                DB::raw('SUM(sale_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $salesChart = Sale::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw("strftime('%Y-%m-%d', created_at) as date"),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recentSales = Sale::with(['customer', 'user', 'items'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalSales', 'totalProfit', 'totalOrders', 'totalCustomers',
            'totalProducts', 'lowStockProducts', 'outOfStockProducts',
            'topProducts', 'salesChart', 'recentSales', 'period'
        ));
    }
}
