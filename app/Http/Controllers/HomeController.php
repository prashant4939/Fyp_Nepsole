<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['images', 'category', 'brand'])
            ->where('is_active', true)
            ->whereHas('images.variants', fn($q) => $q->where('stock', '>', 0))
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts'));
    }
}
