<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = array_sum(array_column($cart, 'subtotal'));
        $user = auth()->user();

        return view('orders.checkout', compact('cart', 'total', 'user'));
    }

    public function store(CheckoutRequest $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Validate stock before creating order
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                if (!$product || $product->stock < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', 'Insufficient stock for "' . $item['name'] . '".');
                }
            }

            $total = array_sum(array_column($cart, 'subtotal'));

            $order = Order::create([
                'user_id'          => auth()->id(),
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'notes'            => $request->notes,
                'total_amount'     => $total,
                'status'           => 'pending',
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $productId,
                    'product_name'  => $item['name'],
                    'product_price' => $item['price'],
                    'quantity'      => $item['quantity'],
                    'subtotal'      => $item['subtotal'],
                ]);

                // Deduct stock
                Product::where('id', $productId)->decrement('stock', $item['quantity']);
            }

            DB::commit();

            session()->forget('cart');

            return redirect()->route('orders.success', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        // Verify order belongs to current user (or allow guest orders)
        if ($order->user_id && auth()->id() !== $order->user_id) {
            abort(403);
        }

        $order->load('items');
        return view('orders.success', compact('order'));
    }

    public function myOrders()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);
        return view('orders.my-orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id && auth()->id() !== $order->user_id) {
            abort(403);
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }
}
