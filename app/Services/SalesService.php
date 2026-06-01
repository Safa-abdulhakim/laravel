<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesService
{
    public function __construct(private InventoryService $inventoryService) {}

    public function createSale(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $items = $data['items'];
            $subtotal = 0;

            // Validate stock availability
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient stock for product: {$product->name}. Available: {$product->quantity}",
                    ]);
                }
            }

            // Calculate subtotal
            $itemsWithPrices = [];
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $lineSubtotal = $product->price * $item['quantity'];
                $subtotal += $lineSubtotal;
                $itemsWithPrices[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $lineSubtotal,
                ];
            }

            $discount = $data['discount'] ?? 0;
            $total = $subtotal - $discount;

            // Create the sale
            $sale = Sale::create([
                'customer_id' => $data['customer_id'] ?? null,
                'user_id' => auth()->id(),
                'invoice_number' => $this->generateInvoiceNumber(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => max(0, $total),
                'payment_method' => $data['payment_method'],
                'status' => 'completed',
                'notes' => $data['notes'] ?? null,
            ]);

            // Create sale items and deduct inventory
            foreach ($itemsWithPrices as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $this->inventoryService->removeStock(
                    $item['product'],
                    $item['quantity'],
                    "Sale #{$sale->invoice_number}",
                    $sale->invoice_number
                );
            }

            return $sale;
        });
    }

    private function generateInvoiceNumber(): string
    {
        $prefix = 'INV-' . date('Ymd') . '-';
        $last = Sale::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        if ($last) {
            $num = intval(substr($last->invoice_number, strlen($prefix))) + 1;
        } else {
            $num = 1;
        }

        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
