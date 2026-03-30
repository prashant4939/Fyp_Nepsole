<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;

class CategoryBrandController extends Controller
{
    /**
     * Display a listing of active categories.
     */
    public function categories()
    {
        $categories = Category::active()
            ->withCount('products')
            ->orderBy('name')
            ->paginate(15);
        
        return view('vendor.categories.index', compact('categories'));
    }

    /**
     * Display a listing of active brands.
     */
    public function brands()
    {
        $brands = Brand::active()
            ->withCount('products')
            ->orderBy('name')
            ->paginate(15);
        
        return view('vendor.brands.index', compact('brands'));
    }
}
