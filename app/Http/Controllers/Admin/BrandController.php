<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::withCount('products')->latest()->paginate(15);
        return view('admin.brands.index', compact('brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:brands,name',
            'logo' => 'nullable|string|max:255',
        ]);

        Brand::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'logo' => $validated['logo'] ?? 'nevixra_assets/images/our-brands-image-1.svg',
        ]);

        return redirect()->back()->with('success', 'Brand created successfully!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:brands,name,' . $id,
            'logo' => 'nullable|string|max:255',
        ]);

        $brand->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'logo' => $validated['logo'] ?? $brand->logo,
        ]);

        return redirect()->back()->with('success', 'Brand updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->back()->with('success', 'Brand deleted successfully!');
    }
}
