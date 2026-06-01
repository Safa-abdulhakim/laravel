<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create Staff
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@inventory.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        // Categories
        $categoriesData = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and accessories'],
            ['name' => 'Clothing', 'description' => 'Apparel and fashion items'],
            ['name' => 'Food & Beverages', 'description' => 'Consumable food and drink products'],
            ['name' => 'Office Supplies', 'description' => 'Stationery and office equipment'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden tools'],
        ];
        $categories = collect($categoriesData)->map(fn ($cat) => Category::create($cat));

        // Products
        $productsData = [
            ['name' => 'Laptop Pro 15"', 'price' => 1299.99, 'quantity' => 25, 'category' => 'Electronics', 'threshold' => 5],
            ['name' => 'Wireless Mouse', 'price' => 29.99, 'quantity' => 100, 'category' => 'Electronics', 'threshold' => 20],
            ['name' => 'USB-C Hub', 'price' => 49.99, 'quantity' => 8, 'category' => 'Electronics', 'threshold' => 10],
            ['name' => 'Mechanical Keyboard', 'price' => 89.99, 'quantity' => 35, 'category' => 'Electronics', 'threshold' => 10],
            ['name' => 'Monitor 27"', 'price' => 399.99, 'quantity' => 15, 'category' => 'Electronics', 'threshold' => 5],
            ['name' => 'Cotton T-Shirt', 'price' => 19.99, 'quantity' => 200, 'category' => 'Clothing', 'threshold' => 50],
            ['name' => 'Denim Jeans', 'price' => 59.99, 'quantity' => 80, 'category' => 'Clothing', 'threshold' => 20],
            ['name' => 'Running Shoes', 'price' => 79.99, 'quantity' => 5, 'category' => 'Clothing', 'threshold' => 10],
            ['name' => 'Premium Coffee Beans', 'price' => 24.99, 'quantity' => 150, 'category' => 'Food & Beverages', 'threshold' => 30],
            ['name' => 'Green Tea Pack', 'price' => 12.99, 'quantity' => 3, 'category' => 'Food & Beverages', 'threshold' => 15],
            ['name' => 'A4 Paper Ream', 'price' => 8.99, 'quantity' => 500, 'category' => 'Office Supplies', 'threshold' => 100],
            ['name' => 'Ballpoint Pen Set', 'price' => 5.99, 'quantity' => 0, 'category' => 'Office Supplies', 'threshold' => 50],
            ['name' => 'Garden Hose', 'price' => 34.99, 'quantity' => 20, 'category' => 'Home & Garden', 'threshold' => 5],
            ['name' => 'Plant Fertilizer', 'price' => 15.99, 'quantity' => 7, 'category' => 'Home & Garden', 'threshold' => 10],
        ];

        $createdProducts = collect();
        foreach ($productsData as $p) {
            $category = $categories->firstWhere('name', $p['category']);
            $status = $p['quantity'] === 0 ? 'out_of_stock' : 'active';
            $product = Product::create([
                'category_id' => $category->id,
                'name' => $p['name'],
                'description' => 'High quality ' . strtolower($p['name']),
                'price' => $p['price'],
                'quantity' => $p['quantity'],
                'low_stock_threshold' => $p['threshold'],
                'sku' => 'PRD-' . strtoupper(Str::random(8)),
                'status' => $status,
            ]);
            $createdProducts->push($product);

            if ($p['quantity'] > 0) {
                InventoryLog::create([
                    'product_id' => $product->id,
                    'user_id' => $admin->id,
                    'type' => 'stock_in',
                    'quantity' => $p['quantity'],
                    'quantity_before' => 0,
                    'quantity_after' => $p['quantity'],
                    'notes' => 'Initial stock',
                    'reference' => 'INIT',
                ]);
            }
        }

        // Customers
        $customersData = [
            ['name' => 'John Smith', 'email' => 'john@example.com', 'phone' => '+1-555-0101', 'address' => '123 Main St, New York, NY'],
            ['name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'phone' => '+1-555-0102', 'address' => '456 Oak Ave, Los Angeles, CA'],
            ['name' => 'Mike Davis', 'email' => 'mike@example.com', 'phone' => '+1-555-0103', 'address' => '789 Pine Rd, Chicago, IL'],
            ['name' => 'Emily Brown', 'email' => 'emily@example.com', 'phone' => '+1-555-0104', 'address' => '321 Elm St, Houston, TX'],
            ['name' => 'David Wilson', 'email' => 'david@example.com', 'phone' => '+1-555-0105', 'address' => '654 Maple Dr, Phoenix, AZ'],
            ['name' => 'Lisa Anderson', 'email' => 'lisa@example.com', 'phone' => '+1-555-0106', 'address' => '987 Cedar Ln, Philadelphia, PA'],
        ];
        $customers = collect($customersData)->map(fn ($c) => Customer::create($c));

        // Sample Sales
        $salesData = [
            [
                'customer' => 'John Smith',
                'items' => [['product' => 'Laptop Pro 15"', 'qty' => 1], ['product' => 'Wireless Mouse', 'qty' => 2]],
                'payment' => 'card',
                'days_ago' => 2,
            ],
            [
                'customer' => 'Sarah Johnson',
                'items' => [['product' => 'Cotton T-Shirt', 'qty' => 3], ['product' => 'Denim Jeans', 'qty' => 2]],
                'payment' => 'cash',
                'days_ago' => 5,
            ],
            [
                'customer' => 'Mike Davis',
                'items' => [['product' => 'Mechanical Keyboard', 'qty' => 1], ['product' => 'USB-C Hub', 'qty' => 1]],
                'payment' => 'card',
                'days_ago' => 7,
            ],
            [
                'customer' => 'Emily Brown',
                'items' => [['product' => 'Premium Coffee Beans', 'qty' => 5], ['product' => 'A4 Paper Ream', 'qty' => 10]],
                'payment' => 'cash',
                'days_ago' => 10,
            ],
            [
                'customer' => 'David Wilson',
                'items' => [['product' => 'Monitor 27"', 'qty' => 1]],
                'payment' => 'bank_transfer',
                'days_ago' => 15,
            ],
        ];

        $invoiceNum = 1;
        foreach ($salesData as $saleData) {
            $customer = $customers->firstWhere('name', $saleData['customer']);
            $subtotal = 0;
            $saleItems = [];

            foreach ($saleData['items'] as $item) {
                $product = $createdProducts->firstWhere('name', $item['product']);
                if ($product && $product->quantity >= $item['qty']) {
                    $lineTotal = $product->price * $item['qty'];
                    $subtotal += $lineTotal;
                    $saleItems[] = ['product' => $product, 'qty' => $item['qty'], 'price' => $product->price, 'subtotal' => $lineTotal];

                    $before = $product->quantity;
                    $after = $before - $item['qty'];
                    $product->update(['quantity' => $after, 'status' => $after > 0 ? 'active' : 'out_of_stock']);
                    $product->refresh();

                    InventoryLog::create([
                        'product_id' => $product->id,
                        'user_id' => $admin->id,
                        'type' => 'stock_out',
                        'quantity' => $item['qty'],
                        'quantity_before' => $before,
                        'quantity_after' => $after,
                        'notes' => 'Sample sale',
                        'reference' => 'INV-SEED-' . str_pad($invoiceNum, 4, '0', STR_PAD_LEFT),
                    ]);
                }
            }

            if (!empty($saleItems)) {
                $sale = Sale::create([
                    'customer_id' => $customer->id,
                    'user_id' => $admin->id,
                    'invoice_number' => 'INV-SEED-' . str_pad($invoiceNum, 4, '0', STR_PAD_LEFT),
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                    'payment_method' => $saleData['payment'],
                    'status' => 'completed',
                    'created_at' => now()->subDays($saleData['days_ago']),
                    'updated_at' => now()->subDays($saleData['days_ago']),
                ]);

                foreach ($saleItems as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product']->id,
                        'quantity' => $item['qty'],
                        'unit_price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                $invoiceNum++;
            }
        }
    }
}
