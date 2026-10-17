<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        // Featured / VIP Products
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('is_featured', true)
            ->take(8)
            ->get();

        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with(['category', 'brand'])
                ->latest('id')
                ->take(8)
                ->get();
        }

        // Asus / Popular Series Products
        $asusProducts = Product::with(['category', 'brand'])
            ->where(function ($q) {
                $q->whereHas('brand', fn($b) => $b->where('name', 'like', '%ASUS%'))
                  ->orWhere('name', 'like', '%Asus%')
                  ->orWhere('name', 'like', '%ExpertBook%')
                  ->orWhere('name', 'like', '%Vivobook%')
                  ->orWhere('name', 'like', '%ZenBook%')
                  ->orWhere('name', 'like', '%ROG%')
                  ->orWhere('name', 'like', '%TUF%');
            })
            ->latest('id')
            ->take(12)
            ->get();

        // Gaming Laptops
        $gamingLaptops = Product::with(['category', 'brand'])
            ->where(function ($q) {
                $q->whereHas('category', fn($c) => $c->where('slug', 'gaming-laptops'))
                  ->orWhere('name', 'like', '%ROG%')
                  ->orWhere('name', 'like', '%TUF%')
                  ->orWhere('name', 'like', '%Legion%')
                  ->orWhere('name', 'like', '%Predator%')
                  ->orWhere('name', 'like', '%Nitro%')
                  ->orWhere('name', 'like', '%Katana%')
                  ->orWhere('name', 'like', '%Alienware%')
                  ->orWhere('name', 'like', '%Razer%');
            })
            ->latest('id')
            ->take(8)
            ->get();

        // Desktop PCs
        $desktopPcs = Product::with(['category', 'brand'])
            ->whereHas('category', fn($c) => $c->where('slug', 'desktop-pc'))
            ->latest('id')
            ->take(8)
            ->get();

        if ($desktopPcs->isEmpty()) {
            $desktopPcs = Product::with(['category', 'brand'])
                ->where('name', 'like', '%PC%')
                ->orWhere('name', 'like', '%Desktop%')
                ->take(8)
                ->get();
        }

        // PC Parts & Components
        $pcComponents = Product::with(['category', 'brand'])
            ->whereHas('category', fn($c) => $c->whereIn('slug', ['pc-components', 'monitors-peripherals']))
            ->latest('id')
            ->take(8)
            ->get();

        if ($pcComponents->isEmpty()) {
            $pcComponents = Product::with(['category', 'brand'])
                ->where(function ($q) {
                    $q->where('name', 'like', '%Core%')
                      ->orWhere('name', 'like', '%RTX%')
                      ->orWhere('name', 'like', '%RAM%')
                      ->orWhere('name', 'like', '%SSD%')
                      ->orWhere('name', 'like', '%Monitor%');
                })
                ->take(8)
                ->get();
        }

        // Deal Products with Discounts
        $dealProducts = Product::whereNotNull('original_price')
            ->whereColumn('original_price', '>', 'price')
            ->orderByRaw('(original_price - price) DESC')
            ->take(8)
            ->get();

        return view('frontend.home', compact(
            'categories',
            'brands',
            'featuredProducts',
            'asusProducts',
            'gamingLaptops',
            'desktopPcs',
            'pcComponents',
            'dealProducts'
        ));
    }

    public function about(): View
    {
        return view('frontend.about');
    }

    public function contact(): View
    {
        return view('frontend.contact');
    }
}
