<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->where('is_active', true);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('brand', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);

        // Preserve query parameters in pagination
        $products->appends($request->query());

        // Get current category and brand for display
        $currentCategory = $request->filled('category') ? Category::find($request->category) : null;
        $currentBrand = $request->filled('brand') ? Brand::find($request->brand) : null;

        return view('customer.products.index', compact('products', 'currentCategory', 'currentBrand'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        $product->load(['category', 'brand', 'images.variants']);
        
        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with(['images'])
            ->limit(4)
            ->get();

        return view('customer.products.show', compact('product', 'relatedProducts'));
    }

    public function byCategory(Category $category)
    {
        $query = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['category', 'brand', 'images']);

        // If brand filter is applied
        if (request()->filled('brand')) {
            $query->where('brand_id', request('brand'));
        }

        $products = $query->latest()->paginate(12);
        $products->appends(request()->query());

        $currentCategory = $category;
        $currentBrand = request()->filled('brand') ? Brand::find(request('brand')) : null;

        return view('customer.products.index', compact('products', 'currentCategory', 'currentBrand'));
    }

    public function byBrand(Brand $brand)
    {
        $query = Product::where('brand_id', $brand->id)
            ->where('is_active', true)
            ->with(['category', 'brand', 'images']);

        // If category filter is applied
        if (request()->filled('category')) {
            $query->where('category_id', request('category'));
        }

        $products = $query->latest()->paginate(12);
        $products->appends(request()->query());

        $currentCategory = request()->filled('category') ? Category::find(request('category')) : null;
        $currentBrand = $brand;

        return view('customer.products.index', compact('products', 'currentCategory', 'currentBrand'));
    }
}
