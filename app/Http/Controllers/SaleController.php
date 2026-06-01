<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Services\SalesService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(private SalesService $salesService) {}

    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'user', 'items']);

        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer_id', $request->customer);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $sales = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $customers = Customer::orderBy('name')->get();

        return view('sales.index', compact('sales', 'customers'));
    }

    public function create()
    {
        $products = Product::where('status', 'active')->where('quantity', '>', 0)->with('category')->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        return view('sales.create', compact('products', 'customers'));
    }

    public function store(StoreSaleRequest $request)
    {
        $sale = $this->salesService->createSale($request->validated());

        return redirect()->route('sales.show', $sale)->with('success', 'Sale created successfully. Invoice: ' . $sale->invoice_number);
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'user', 'items.product.category']);
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        if ($sale->status === 'completed') {
            return redirect()->route('sales.index')
                ->with('error', 'Cannot delete a completed sale.');
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
