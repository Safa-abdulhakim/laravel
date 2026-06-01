<?php

namespace App\Services;

use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public function addStock(Product $product, int $quantity, string $notes = '', string $reference = ''): InventoryLog
    {
        return DB::transaction(function () use ($product, $quantity, $notes, $reference) {
            $before = $product->quantity;
            $after = $before + $quantity;

            $product->update([
                'quantity' => $after,
                'status' => $after > 0 ? 'active' : 'out_of_stock',
            ]);

            return InventoryLog::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'stock_in',
                'quantity' => $quantity,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'notes' => $notes,
                'reference' => $reference,
            ]);
        });
    }

    public function removeStock(Product $product, int $quantity, string $notes = '', string $reference = ''): InventoryLog
    {
        return DB::transaction(function () use ($product, $quantity, $notes, $reference) {
            $before = $product->quantity;
            $after = max(0, $before - $quantity);

            $product->update([
                'quantity' => $after,
                'status' => $after > 0 ? 'active' : 'out_of_stock',
            ]);

            return InventoryLog::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'stock_out',
                'quantity' => $quantity,
                'quantity_before' => $before,
                'quantity_after' => $after,
                'notes' => $notes,
                'reference' => $reference,
            ]);
        });
    }

    public function adjustStock(Product $product, int $newQuantity, string $notes = ''): InventoryLog
    {
        return DB::transaction(function () use ($product, $newQuantity, $notes) {
            $before = $product->quantity;

            $product->update([
                'quantity' => $newQuantity,
                'status' => $newQuantity > 0 ? 'active' : 'out_of_stock',
            ]);

            return InventoryLog::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'adjustment',
                'quantity' => abs($newQuantity - $before),
                'quantity_before' => $before,
                'quantity_after' => $newQuantity,
                'notes' => $notes,
            ]);
        });
    }
}
