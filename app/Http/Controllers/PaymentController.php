<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public static function getBankAccounts(): array
    {
        return [
            'aba_khqr' => [
                'name' => 'ABA Bank (KHQR / Bakong)',
                'bank_short' => 'ABA PAY',
                'account_name' => Setting::get('aba_account_name', 'QuickTech Cambodia'),
                'account_no' => Setting::get('aba_account_no', '001 646 581 (USD)'),
                'color' => '#005f73',
                'accent' => '#0a9396',
                'badge' => 'ABA KHQR',
                'instructions' => 'Open ABA Mobile > Tap Scan QR > Scan this KHQR > Confirm Payment',
            ],
            'acleda_khqr' => [
                'name' => 'ACLEDA Bank Plc. (KHQR)',
                'bank_short' => 'ACLEDA KHQR',
                'account_name' => Setting::get('acleda_account_name', 'QuickTech Cambodia'),
                'account_no' => Setting::get('acleda_account_no', '1800-0156-4658 (USD)'),
                'color' => '#002855',
                'accent' => '#e0a96d',
                'badge' => 'ACLEDA KHQR',
                'instructions' => 'Open ACLEDA Mobile app > Scan KHQR > Verify amount & complete payment',
            ],
            'wing_khqr' => [
                'name' => 'Wing Bank (Cambodia) Plc. (KHQR)',
                'bank_short' => 'Wing KHQR',
                'account_name' => Setting::get('wing_account_name', 'QuickTech Cambodia'),
                'account_no' => Setting::get('wing_account_no', '0345 8899 (USD)'),
                'color' => '#00529b',
                'accent' => '#78be20',
                'badge' => 'Wing KHQR',
                'instructions' => 'Open Wing Bank App > Tap KHQR Scan > Confirm payment of the exact amount',
            ],
        ];
    }

    public function show(string $orderNumber): View|RedirectResponse
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->firstOrFail();

        $bankAccounts = self::getBankAccounts();
        $bankInfo = $bankAccounts[$order->payment_method] ?? $bankAccounts['aba_khqr'];

        // Dynamic QR code payload url or display QR (uses api.qrserver.com or local SVG)
        $qrPayload = sprintf(
            'https://bakong.nbc.org.kh/khqr?merchant=%s&account=%s&amount=%.2f&currency=USD&order=%s',
            urlencode($bankInfo['account_name']),
            urlencode($bankInfo['account_no']),
            $order->total,
            $order->order_number
        );

        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=10&data=' . urlencode($qrPayload);

        return view('frontend.payment', compact('order', 'bankInfo', 'qrCodeUrl', 'qrPayload'));
    }

    public function uploadSlip(Request $request, string $orderNumber): RedirectResponse
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'payment_reference' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('payment_slip')) {
            $file = $request->file('payment_slip');
            $filename = 'slip_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_slips', $filename, 'public');

            $order->update([
                'payment_slip' => $path,
                'payment_status' => 'paid',
                'order_status' => 'confirmed',
                'confirmed_at' => now(),
            ]);

            return redirect()->route('order.success', $order->order_number)
                ->with('success', 'Payment slip uploaded! Your order #' . $order->order_number . ' has been submitted and confirmed.');
        }

        return redirect()->back()->with('error', 'Please select a valid image screenshot/slip.');
    }

    public function success(string $orderNumber): View
    {
        $order = Order::with('items.product')->where('order_number', $orderNumber)->firstOrFail();
        return view('frontend.order-success', compact('order'));
    }
}
