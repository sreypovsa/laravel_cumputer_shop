<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with('items.product')->latest();

        // Filter by order status
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('order_status', $request->input('status'));
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // Search
        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%{$s}%")
                  ->orWhere('tracking_code', 'like', "%{$s}%")
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('customer_phone', 'like', "%{$s}%")
                  ->orWhere('customer_email', 'like', "%{$s}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => Order::count(),
            'pending' => Order::where('order_status', 'pending')->count(),
            'confirmed' => Order::where('order_status', 'confirmed')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipping' => Order::where('order_status', 'shipping')->count(),
            'delivered' => Order::where('order_status', 'delivered')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show(int $id): View
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|in:pending,confirmed,processing,shipping,delivered,cancelled',
            'payment_status' => 'required|in:pending,paid,rejected',
            'courier_tracking_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $data = [
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
            'courier_tracking_number' => $request->courier_tracking_number,
            'notes' => $request->notes,
        ];

        if ($request->order_status === 'confirmed' && !$order->confirmed_at) {
            $data['confirmed_at'] = now();
        }

        if ($request->order_status === 'shipping' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }

        if ($request->order_status === 'delivered' && !$order->delivered_at) {
            $data['delivered_at'] = now();
        }

        $order->update($data);

        return redirect()->back()->with('success', 'Order #' . $order->order_number . ' updated successfully!');
    }

    public function quickConfirm(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => 'confirmed',
            'payment_status' => 'paid',
            'confirmed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Order #' . $order->order_number . ' has been confirmed!');
    }

    public function invoice(int $id): View
    {
        $order = Order::with('items.product')->findOrFail($id);
        $settings = \App\Models\Setting::getAll();
        return view('admin.invoices.show', compact('order', 'settings'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order #' . $order->order_number . ' deleted successfully.');
    }
}
