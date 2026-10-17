<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $accountCount = User::where('is_admin', false)->count();

        // "Registered accounts" tab: every customer who signed up, including those with no orders yet
        if ($request->input('view') === 'accounts') {
            $accounts = User::where('is_admin', false)
                ->withCount('orders')
                ->withSum('orders', 'total')
                ->when($search, fn ($q) => $q->where(fn ($w) => $w
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")))
                ->latest()
                ->paginate(15)
                ->withQueryString();

            return view('admin.customers.index', compact('accounts', 'accountCount'));
        }

        $query = Order::selectRaw('
                MAX(customer_name) as customer_name, 
                customer_phone, 
                MAX(customer_email) as customer_email, 
                MAX(delivery_province) as delivery_province, 
                COUNT(id) as total_orders, 
                SUM(total) as total_spent, 
                MAX(created_at) as last_order_at,
                MAX(user_id) as user_id
            ')
            ->groupBy('customer_phone');

        if (!empty($search)) {
            $query->havingRaw('MAX(customer_name) LIKE ? OR customer_phone LIKE ? OR MAX(customer_email) LIKE ?', [
                "%{$search}%", "%{$search}%", "%{$search}%"
            ]);
        }

        $customers = $query->orderByDesc('last_order_at')->paginate(15)->withQueryString();

        return view('admin.customers.index', compact('customers', 'accountCount'));
    }

    public function show(string $phone): View
    {
        $decodedPhone = urldecode($phone);
        $cleanPhone = preg_replace('/[^0-9]/', '', $decodedPhone);

        $orders = Order::with('items.product')
            ->where('customer_phone', $decodedPhone)
            ->orWhere('customer_phone', $phone)
            ->orWhereRaw('REPLACE(customer_phone, " ", "") = ?', [$cleanPhone])
            ->latest()
            ->get();

        $customer = $orders->first();

        return view('admin.customers.show', compact('orders', 'customer', 'phone'));
    }
}
