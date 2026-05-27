<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::where('status', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $categories = Product::where('status', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('home', compact('featured', 'categories'));
    }
}
