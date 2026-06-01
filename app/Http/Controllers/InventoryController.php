<?php

namespace App\Http\Controllers;

use App\Models\InventoryLog;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct(private InventoryService $inventoryService) {}

    public function index(Request $request)
    {
        $query = InventoryLog::with(['product', 'user']);

        if ($request->filled('product')) {
            $query->where('product_id', $request->product);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('inventory.index', compact('logs', 'products'));
    }

    public function stockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'reference' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->inventoryService->addStock($product, $request->quantity, $request->notes ?? '', $request->reference ?? '');

        return redirect()->route('inventory.index')
            ->with('success', "Added {$request->quantity} units to {$product->name}.");
    }

    public function stockOut(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity < $request->quantity) {
            return back()->with('error', "Insufficient stock. Available: {$product->quantity}");
        }

        $this->inventoryService->removeStock($product, $request->quantity, $request->notes ?? '');

        return redirect()->route('inventory.index')
            ->with('success', "Removed {$request->quantity} units from {$product->name}.");
    }

    public function adjust(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'new_quantity' => 'required|integer|min:0',
            'notes' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->inventoryService->adjustStock($product, $request->new_quantity, $request->notes);

        return redirect()->route('inventory.index')
            ->with('success', "Stock adjusted for {$product->name}.");
    }
}
