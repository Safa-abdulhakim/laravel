<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart = $this->getCart();
        $total = $this->calculateTotal($cart);
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        if (!$product->status || $product->stock <= 0) {
            return back()->with('error', 'Product is not available.');
        }

        $quantity = (int) $request->quantity;
        $cart = $this->getCart();

        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['quantity'] + $quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Not enough stock available. Available: ' . $product->stock);
            }
            $cart[$product->id]['quantity'] = $newQty;
            $cart[$product->id]['subtotal'] = $newQty * $product->price;
        } else {
            if ($quantity > $product->stock) {
                return back()->with('error', 'Not enough stock available. Available: ' . $product->stock);
            }
            $cart[$product->id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $quantity,
                'subtotal' => $quantity * $product->price,
                'stock'    => $product->stock,
            ];
        }

        $this->saveCart($cart);

        return back()->with('success', '"' . $product->name . '" added to cart successfully!');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = $this->getCart();

        if (!isset($cart[$productId])) {
            return back()->with('error', 'Product not found in cart.');
        }

        $product = Product::find($productId);
        $quantity = (int) $request->quantity;

        if ($product && $quantity > $product->stock) {
            return back()->with('error', 'Not enough stock. Available: ' . $product->stock);
        }

        $cart[$productId]['quantity'] = $quantity;
        $cart[$productId]['subtotal'] = $quantity * $cart[$productId]['price'];

        $this->saveCart($cart);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove($productId)
    {
        $cart = $this->getCart();
        $name = $cart[$productId]['name'] ?? 'Item';

        unset($cart[$productId]);
        $this->saveCart($cart);

        return back()->with('success', '"' . $name . '" removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }

    private function calculateTotal(array $cart): float
    {
        return array_sum(array_column($cart, 'subtotal'));
    }

    public static function cartCount(): int
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
}
