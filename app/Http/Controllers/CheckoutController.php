<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public const PROVINCES = [
        'Phnom Penh',
        'Kandal',
        'Siem Reap',
        'Battambang',
        'Preah Sihanouk',
        'Kampot',
        'Kampong Cham',
        'Kampong Chhnang',
        'Kampong Speu',
        'Kampong Thom',
        'Kep',
        'Koh Kong',
        'Kratie',
        'Mondulkiri',
        'Oddar Meanchey',
        'Pailin',
        'Preah Vihear',
        'Prey Veng',
        'Pursat',
        'Ratanakiri',
        'Stung Treng',
        'Svay Rieng',
        'Takeo',
        'Tboung Khmum',
        'Banteay Meanchey',
    ];

    public const CARRIERS = [
        'Phnom Penh Same-Day Express' => ['fee' => 1.50, 'desc' => 'Fast 2-4 hours delivery inside Phnom Penh'],
        'Virak Buntham (VET Express)' => ['fee' => 2.50, 'desc' => 'Nationwide coverage across all 25 provinces'],
        'J&T Express Cambodia' => ['fee' => 2.00, 'desc' => 'Door-to-door delivery across Cambodia'],
        'Capitol Express' => ['fee' => 1.50, 'desc' => 'Reliable provincial bus station / branch pickup'],
    ];

    public function index(): View|RedirectResponse
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('warning', 'Your cart is empty. Please add items before checking out.');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $provinces = self::PROVINCES;
        $carriers = self::CARRIERS;

        return view('frontend.checkout', compact('cart', 'subtotal', 'provinces', 'carriers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your shopping cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:191',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:191',
            'delivery_province' => 'required|string|max:100',
            'delivery_district' => 'nullable|string|max:100',
            'delivery_commune' => 'nullable|string|max:100',
            'delivery_address' => 'required|string',
            'delivery_carrier' => 'required|string',
            'payment_method' => 'required|in:aba_khqr,acleda_khqr,wing_khqr,cod',
            'notes' => 'nullable|string',
        ]);

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $carrier = $request->input('delivery_carrier');
        $shippingFee = self::CARRIERS[$carrier]['fee'] ?? 2.00;

        $total = $subtotal + $shippingFee;

        // Generate clean unique Order # and Tracking Code
        $orderNumber = 'CC-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $trackingCode = 'TRK-' . mt_rand(100000, 999999);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'tracking_code' => $trackingCode,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_province' => $request->delivery_province,
                'delivery_district' => $request->delivery_district,
                'delivery_commune' => $request->delivery_commune,
                'delivery_address' => $request->delivery_address,
                'delivery_carrier' => $carrier,
                'shipping_fee' => $shippingFee,
                'subtotal' => $subtotal,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'notes' => $request->notes,
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_code' => $item['code'] ?? null,
                    'product_image' => $item['image'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            // If QR payment method (ABA, ACLEDA, Wing), redirect to QR payment page
            if (in_array($order->payment_method, ['aba_khqr', 'acleda_khqr', 'wing_khqr'])) {
                return redirect()->route('payment.show', $order->order_number)->with('success', 'Order created! Please scan the QR code to complete your payment.');
            }

            // COD orders go directly to success
            return redirect()->route('order.success', $order->order_number)->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
