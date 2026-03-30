<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of brands.
     */
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created brand.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = $request->only(['name']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brand_logos', 'public');
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand created successfully!');
    }

    /**
     * Show the form for editing the brand.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $data = $request->only(['name']);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $request->file('logo')->store('brand_logos', 'public');
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified brand.
     */
    public function destroy(Brand $brand)
    {
        // Check if brand has products
        if ($brand->products()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Cannot delete brand! It has ' . $brand->products()->count() . ' product(s) linked to it. Please remove or reassign the products first.');
        }

        // Delete logo if exists
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully!');
    }

    /**
     * Toggle brand active status.
     */
    public function toggleStatus(Brand $brand)
    {
        // If trying to deactivate, check if it has active products
        if ($brand->is_active) {
            $activeProductsCount = $brand->products()->where('is_active', true)->count();
            
            if ($activeProductsCount > 0) {
                return redirect()->route('admin.brands.index')
                    ->with('error', "Cannot deactivate brand! It has {$activeProductsCount} active product(s) linked to it. Please deactivate those products first.");
            }
        }

        $brand->update(['is_active' => !$brand->is_active]);

        $status = $brand->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.brands.index')
            ->with('success', "Brand {$status} successfully!");
    }
}