<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackingController extends Controller
{
    public function index(Request $request): View
    {
        $code = trim($request->input('code', ''));
        $order = null;
        $recentOrders = null;

        if (!empty($code)) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $code);

            $order = Order::with('items.product')
                ->where('tracking_code', $code)
                ->orWhere('order_number', $code)
                ->orWhere(function ($query) use ($code, $cleanPhone) {
                    $query->where('customer_phone', $code);
                    if (strlen($cleanPhone) >= 8) {
                        $query->orWhere('customer_phone', 'like', '%' . $cleanPhone . '%');
                    }
                })
                ->latest()
                ->first();
        }

        // Provide demo tracking codes for immediate test convenience
        $sampleTrackingCodes = Order::latest()->take(3)->pluck('tracking_code', 'order_number');

        return view('frontend.track-order', compact('order', 'code', 'sampleTrackingCodes'));
    }

    public function show(string $code): View
    {
        $order = Order::with('items.product')
            ->where('tracking_code', $code)
            ->orWhere('order_number', $code)
            ->firstOrFail();

        $sampleTrackingCodes = Order::latest()->take(3)->pluck('tracking_code', 'order_number');

        return view('frontend.track-order', [
            'order' => $order,
            'code' => $code,
            'sampleTrackingCodes' => $sampleTrackingCodes,
        ]);
    }
}
