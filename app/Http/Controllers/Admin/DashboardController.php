<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('payment_status', ['paid'])
            ->orWhereIn('order_status', ['confirmed', 'processing', 'shipping', 'delivered'])
            ->sum('total');

        $pendingOrders = Order::where('order_status', 'pending')->count();
        $confirmedOrders = Order::where('order_status', 'confirmed')->count();
        $shippingOrders = Order::where('order_status', 'shipping')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();

        $totalProducts = Product::count();
        $totalCustomers = User::where('is_admin', false)->count();

        $recentOrders = Order::with('items.product')->latest()->take(10)->get();
        $topCategories = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'confirmedOrders',
            'shippingOrders',
            'deliveredOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'topCategories'
        ));
    }
}
