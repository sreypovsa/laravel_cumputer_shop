<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('frontend.cart', compact('cart', 'subtotal'));
    }

    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $productId = $request->input('product_id');
        $quantity = max(1, (int)$request->input('quantity', 1));

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'price' => (float)$product->price,
                'original_price' => (float)$product->original_price,
                'quantity' => $quantity,
                'image' => $product->image_url,
                'slug' => $product->slug,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Added to cart successfully!',
                'cart_count' => $cartCount,
                'subtotal' => number_format($subtotal, 2),
                'item' => $cart[$productId],
            ]);
        }

        if ($request->boolean('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->back()->with('success', 'Product added to your cart!');
    }

    public function update(Request $request): JsonResponse|RedirectResponse
    {
        $productId = $request->input('product_id');
        $quantity = (int)$request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => $cartCount,
                'item_total' => isset($cart[$productId]) ? number_format($cart[$productId]['price'] * $cart[$productId]['quantity'], 2) : 0,
                'subtotal' => number_format($subtotal, 2),
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $cartCount,
                'subtotal' => number_format($subtotal, 2),
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully');
    }
}
