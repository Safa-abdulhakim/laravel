<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%')
                  ->orWhere('id', $request->search);
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $statusList = Order::statusList();

        return view('admin.orders.index', compact('orders', 'statusList'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        $statusList = Order::statusList();

        return view('admin.orders.show', compact('order', 'statusList'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Order::statusList()),
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated to "' . ucfirst($request->status) . '".');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order #' . $order->id . ' deleted successfully.');
    }
}
