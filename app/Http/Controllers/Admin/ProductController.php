<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'brand'])->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%");
            });
        }

        $products = $query->paginate(20)->withQueryString();
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'code' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'specs' => 'nullable|string',
            'description' => 'nullable|string',
            'free_gifts' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'image_file' => 'nullable|image|max:3072',
            'image_url' => 'nullable|url',
        ]);

        $image = $validated['image_url'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $image = 'storage/' . $path;
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'] ?? null,
            'code' => $validated['code'] ?? 'CC-' . strtoupper(Str::random(6)),
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'stock' => $validated['stock'],
            'image' => $image,
            'specs' => $validated['specs'] ?? null,
            'description' => $validated['description'] ?? null,
            'free_gifts' => $validated['free_gifts'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'status' => 'active',
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'code' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'specs' => 'nullable|string',
            'description' => 'nullable|string',
            'free_gifts' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'image_file' => 'nullable|image|max:3072',
            'image_url' => 'nullable|string',
        ]);

        $image = $product->image;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $image = 'storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $image = $validated['image_url'];
        }

        $product->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'] ?? null,
            'code' => $validated['code'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'stock' => $validated['stock'],
            'image' => $image,
            'specs' => $validated['specs'] ?? null,
            'description' => $validated['description'] ?? null,
            'free_gifts' => $validated['free_gifts'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function duplicate(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $newProduct = $product->replicate();
        $newProduct->name = $product->name . ' (Copy)';
        $newProduct->slug = Str::slug($newProduct->name) . '-' . Str::random(5);
        $newProduct->code = 'CC-' . strtoupper(Str::random(6));
        $newProduct->save();

        return redirect()->route('admin.products.edit', $newProduct->id)->with('success', 'Product duplicated successfully!');
    }
}
