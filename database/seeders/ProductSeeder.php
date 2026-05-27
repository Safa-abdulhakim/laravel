<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'name'        => 'Wireless Bluetooth Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life. Perfect for music lovers and professionals alike.',
                'price'       => 89.99,
                'stock'       => 50,
                'category'    => 'Electronics',
                'status'      => true,
            ],
            [
                'name'        => 'Smart Watch Pro',
                'description' => 'Feature-packed smartwatch with health monitoring, GPS, and 7-day battery life. Water resistant up to 50 meters.',
                'price'       => 199.99,
                'stock'       => 30,
                'category'    => 'Electronics',
                'status'      => true,
            ],
            [
                'name'        => 'USB-C Fast Charger 65W',
                'description' => 'Universal fast charger compatible with laptops, phones, and tablets. Charges most devices to 50% in 30 minutes.',
                'price'       => 29.99,
                'stock'       => 100,
                'category'    => 'Electronics',
                'status'      => true,
            ],
            [
                'name'        => 'Portable Bluetooth Speaker',
                'description' => 'Waterproof portable speaker with 360° sound, 24-hour playtime. Perfect for outdoor adventures.',
                'price'       => 59.99,
                'stock'       => 45,
                'category'    => 'Electronics',
                'status'      => true,
            ],
            // Clothing
            [
                'name'        => 'Classic Cotton T-Shirt',
                'description' => 'Comfortable 100% organic cotton t-shirt. Available in multiple colors. Machine washable.',
                'price'       => 24.99,
                'stock'       => 200,
                'category'    => 'Clothing',
                'status'      => true,
            ],
            [
                'name'        => 'Denim Jacket',
                'description' => 'Timeless denim jacket with a modern fit. Perfect for casual and semi-formal occasions.',
                'price'       => 79.99,
                'stock'       => 60,
                'category'    => 'Clothing',
                'status'      => true,
            ],
            [
                'name'        => 'Running Sneakers',
                'description' => 'Lightweight and breathable running shoes with advanced cushioning technology. Ideal for daily training.',
                'price'       => 119.99,
                'stock'       => 80,
                'category'    => 'Clothing',
                'status'      => true,
            ],
            // Books
            [
                'name'        => 'Laravel: Up & Running',
                'description' => 'A comprehensive guide to Laravel framework. Covers everything from basics to advanced features and best practices.',
                'price'       => 39.99,
                'stock'       => 25,
                'category'    => 'Books',
                'status'      => true,
            ],
            [
                'name'        => 'Clean Code',
                'description' => 'A handbook of agile software craftsmanship by Robert C. Martin. A must-read for every developer.',
                'price'       => 34.99,
                'stock'       => 40,
                'category'    => 'Books',
                'status'      => true,
            ],
            // Home & Garden
            [
                'name'        => 'Stainless Steel Water Bottle',
                'description' => 'Insulated 1-liter water bottle keeps drinks cold for 24 hours or hot for 12 hours. BPA-free.',
                'price'       => 19.99,
                'stock'       => 150,
                'category'    => 'Home & Garden',
                'status'      => true,
            ],
            [
                'name'        => 'Ergonomic Office Chair',
                'description' => 'Adjustable lumbar support office chair with breathable mesh back. Designed for long working hours.',
                'price'       => 299.99,
                'stock'       => 15,
                'category'    => 'Home & Garden',
                'status'      => true,
            ],
            [
                'name'        => 'LED Desk Lamp',
                'description' => 'Eye-care LED desk lamp with 5 color temperatures and 7 brightness levels. USB charging port included.',
                'price'       => 44.99,
                'stock'       => 70,
                'category'    => 'Home & Garden',
                'status'      => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
