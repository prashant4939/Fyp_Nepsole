<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        $products = $vendor->products()->with(['category', 'brand', 'images'])->latest()->paginate(10);
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        return view('vendor.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_details' => 'nullable|string',
            'size_and_fit' => 'nullable|string',
            'handle_and_care' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'images.*.file' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'images.*.sizes.*.size' => 'required|string',
            'images.*.sizes.*.stock' => 'required|integer|min:1',
        ]);

        $vendor = auth()->user()->vendor;

        // Create product
        $product = Product::create([
            'vendor_id' => $vendor->id,
            'name' => $request->name,
            'description' => $request->description,
            'product_details' => $request->product_details,
            'size_and_fit' => $request->size_and_fit,
            'handle_and_care' => $request->handle_and_care,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'is_active' => true,
            'sold' => 0,
        ]);

        // Handle images and variants
        if ($request->has('images')) {
            foreach ($request->input('images') as $index => $imageData) {
                if ($request->hasFile("images.{$index}.file")) {
                    $file = $request->file("images.{$index}.file");
                    $path = $file->store('product_images', 'public');
                    
                    $productImage = ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                    
                    // Create variants for this image
                    if (isset($imageData['sizes'])) {
                        foreach ($imageData['sizes'] as $sizeData) {
                            if (!empty($sizeData['size']) && !empty($sizeData['stock'])) {
                                ProductVariant::create([
                                    'product_image_id' => $productImage->id,
                                    'size' => $sizeData['size'],
                                    'stock' => (int)$sizeData['stock'],
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $product->load(['category', 'brand', 'images.variants']);
        return view('vendor.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::active()->orderBy('name')->get();
        $brands = Brand::active()->orderBy('name')->get();
        $product->load(['images.variants']);
        
        return view('vendor.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        // Check authorization
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'product_details' => 'nullable|string',
            'size_and_fit' => 'nullable|string',
            'handle_and_care' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'existing_variants.*.size' => 'nullable|string',
            'existing_variants.*.stock' => 'nullable|integer|min:0',
            'new_variants.*.*.size' => 'nullable|string',
            'new_variants.*.*.stock' => 'nullable|integer|min:1',
            'new_images.*.file' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'new_images.*.sizes.*.size' => 'required_with:new_images.*.file|string',
            'new_images.*.sizes.*.stock' => 'required_with:new_images.*.file|integer|min:1',
        ]);

        // Update product basic info
        $product->update($validated);

        // Update existing variants
        if ($request->has('existing_variants')) {
            foreach ($request->existing_variants as $variantId => $variantData) {
                $variant = ProductVariant::find($variantId);
                if ($variant && $variant->productImage->product_id == $product->id) {
                    $variant->update([
                        'size' => $variantData['size'],
                        'stock' => $variantData['stock'],
                    ]);
                }
            }
        }

        // Delete marked variants
        if ($request->has('delete_variants')) {
            foreach ($request->delete_variants as $variantId) {
                $variant = ProductVariant::find($variantId);
                if ($variant && $variant->productImage->product_id == $product->id) {
                    // Check for active orders before deleting
                    $hasOrders = \App\Models\OrderItem::where('product_variant_id', $variant->id)
                        ->whereIn('status', ['pending', 'confirmed'])
                        ->exists();
                    if (!$hasOrders) {
                        $variant->delete();
                    }
                }
            }
        }

        // Add new variants to existing images
        if ($request->has('new_variants')) {
            foreach ($request->new_variants as $imageId => $variants) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    foreach ($variants as $variantData) {
                        if (!empty($variantData['size']) && !empty($variantData['stock'])) {
                            ProductVariant::create([
                                'product_image_id' => $imageId,
                                'size' => $variantData['size'],
                                'stock' => (int)$variantData['stock'],
                            ]);
                        }
                    }
                }
            }
        }

        // Handle new images if any
        if ($request->has('new_images')) {
            foreach ($request->input('new_images') as $index => $imageData) {
                if ($request->hasFile("new_images.{$index}.file")) {
                    $file = $request->file("new_images.{$index}.file");
                    $path = $file->store('product_images', 'public');
                    
                    $productImage = ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                    
                    // Create variants for this image
                    if (isset($imageData['sizes'])) {
                        foreach ($imageData['sizes'] as $sizeData) {
                            if (!empty($sizeData['size']) && !empty($sizeData['stock'])) {
                                ProductVariant::create([
                                    'product_image_id' => $productImage->id,
                                    'size' => $sizeData['size'],
                                    'stock' => (int)$sizeData['stock'],
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete images from storage
        foreach ($product->images as $image) {
            if ($image->image) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully!');
    }
    
    // Image Management Methods
    public function storeImage(Request $request, Product $product)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'sizes.*.size' => 'required|string',
            'sizes.*.stock' => 'required|integer|min:1',
        ]);

        // Upload image
        $path = $request->file('image')->store('product_images', 'public');
        
        $productImage = ProductImage::create([
            'product_id' => $product->id,
            'image' => $path,
        ]);
        
        // Create variants
        if ($request->has('sizes')) {
            foreach ($request->sizes as $sizeData) {
                ProductVariant::create([
                    'product_image_id' => $productImage->id,
                    'size' => $sizeData['size'],
                    'stock' => (int)$sizeData['stock'],
                ]);
            }
        }

        return redirect()->route('vendor.products.edit', $product)
            ->with('success', 'Image added successfully!');
    }
    
    public function deleteImage(Product $product, ProductImage $image)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image file from storage
        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return redirect()->route('vendor.products.edit', $product)
            ->with('success', 'Image deleted successfully!');
    }
    
    // Variant Management Methods
    public function storeVariant(Request $request, Product $product, ProductImage $image)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'size' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        ProductVariant::create([
            'product_image_id' => $image->id,
            'size' => $request->size,
            'stock' => $request->stock,
        ]);

        return redirect()->route('vendor.products.edit', $product)
            ->with('success', 'Size added successfully!');
    }
    
    public function updateVariant(Request $request, Product $product, ProductVariant $variant)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'size' => 'required|string',
            'stock' => 'required|integer|min:0',
        ]);

        $variant->update([
            'size' => $request->size,
            'stock' => $request->stock,
        ]);

        return redirect()->route('vendor.products.edit', $product)
            ->with('success', 'Size updated successfully!');
    }
    
    public function deleteVariant(Product $product, ProductVariant $variant)
    {
        if ($product->vendor_id !== auth()->user()->vendor->id) {
            abort(403, 'Unauthorized action.');
        }

        // Prevent deletion if variant has active orders
        $hasOrders = \App\Models\OrderItem::where('product_variant_id', $variant->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasOrders) {
            return redirect()->route('vendor.products.edit', $product)
                ->with('error', 'Cannot delete this size — it has active orders associated with it.');
        }

        $variant->delete();

        return redirect()->route('vendor.products.edit', $product)
            ->with('success', 'Size deleted successfully!');
    }
}